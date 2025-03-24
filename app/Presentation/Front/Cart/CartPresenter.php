<?php

declare(strict_types=1);

namespace App\Presentation\Front\Cart;

use App\Presentation\Front\FrontPresenter;
use App\Presentation\Accessory\Repository\ProductRepository;
use App\Presentation\Accessory\Repository\OrderRepository;
use App\Presentation\Accessory\Repository\UserRepository;
use Nette\Application\UI\Form;
use Nette\Http\Session;
use Nette\Http\SessionSection;

final class CartPresenter extends FrontPresenter
{
    private SessionSection $cartSession;
    private ProductRepository $productRepository;
    private OrderRepository $orderRepository;
    private UserRepository $userRepository;

    public function __construct(
        Session $session, 
        ProductRepository $productRepository,
        OrderRepository $orderRepository,
        UserRepository $userRepository
    )
    {
        parent::__construct();
        $this->cartSession = $session->getSection('cart');
        $this->productRepository = $productRepository;
        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
        
        // Inicializace košíku, pokud ještě neexistuje
        if (!isset($this->cartSession->items)) {
            $this->cartSession->items = [];
        }
    }

    public function renderDefault(): void
    {
        $cartItems = [];
        $totalPrice = 0;
        
        // Načtení detailů produktů v košíku
        foreach ($this->cartSession->items as $productId => $quantity) {
            $product = $this->productRepository->getById((int)$productId);
            if ($product) {
                $itemPrice = $product->price * $quantity;
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'price' => $itemPrice
                ];
                $totalPrice += $itemPrice;
            }
        }
        
        $this->template->cartItems = $cartItems;
        $this->template->totalPrice = $totalPrice;
        $this->template->pageTitle = 'Košík';
    }

    public function actionAdd(int $productId): void
    {
        $product = $this->productRepository->getById($productId);
        
        if (!$product) {
            $this->flashMessage('Produkt nebyl nalezen.', 'danger');
            $this->redirect('Catalog:default');
        }
        
        // Přidání nebo navýšení množství produktu v košíku
        if (isset($this->cartSession->items[$productId])) {
            $this->cartSession->items[$productId]++;
        } else {
            $this->cartSession->items[$productId] = 1;
        }
        
        $this->flashMessage('Produkt byl přidán do košíku.', 'success');
        $this->redirect('Cart:default');
    }
    
    public function actionRemove(int $productId): void
    {
        if (isset($this->cartSession->items[$productId])) {
            unset($this->cartSession->items[$productId]);
            $this->flashMessage('Produkt byl odebrán z košíku.', 'success');
        }
        $this->redirect('Cart:default');
    }
    
    public function handleUpdateQuantity(int $productId, int $quantity): void
    {
        if ($quantity > 0) {
            $this->cartSession->items[$productId] = $quantity;
        } else {
            unset($this->cartSession->items[$productId]);
        }
        $this->redirect('this');
    }

    public function actionCheckout(): void
    {
        if (empty($this->cartSession->items)) {
            $this->flashMessage('Váš košík je prázdný.', 'warning');
            $this->redirect('Catalog:default');
        }
        
        // Načtení detailů produktů v košíku pro zobrazení souhrnu
        $cartItems = [];
        $totalPrice = 0;
        
        foreach ($this->cartSession->items as $productId => $quantity) {
            $product = $this->productRepository->getById((int)$productId);
            if ($product) {
                $itemPrice = $product->price * $quantity;
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'price' => $itemPrice
                ];
                $totalPrice += $itemPrice;
            }
        }
        
        $this->template->cartItems = $cartItems;
        $this->template->totalPrice = $totalPrice;
        
        // Pokud je uživatel přihlášen, načteme jeho údaje
        if ($this->getUser()->isLoggedIn()) {
            $userData = $this->userRepository->getById($this->getUser()->getId());
            $this->template->userData = $userData;
        }
        
        $this->template->pageTitle = 'Dokončení objednávky';
    }
    
    protected function createComponentCheckoutForm(): Form
    {
        $form = new Form;
        
        $form->addText('name', 'Jméno a příjmení:')
            ->setRequired('Prosím vyplňte jméno a příjmení.');
            
        $form->addEmail('email', 'E-mail:')
            ->setRequired('Prosím vyplňte e-mail.');
            
        $form->addText('phone', 'Telefon:')
            ->setRequired('Prosím vyplňte telefon.');
            
        $form->addTextArea('address', 'Adresa:')
            ->setRequired('Prosím vyplňte adresu.');
            
        $form->addTextArea('note', 'Poznámka:')
            ->setRequired(false);
            
        $form->addSubmit('submit', 'Dokončit objednávku');
        
        // Pokud je uživatel přihlášen, předvyplníme údaje
        if ($this->getUser()->isLoggedIn()) {
            $userData = $this->userRepository->getById($this->getUser()->getId());
            
            if ($userData) {
                $form->setDefaults([
                    'name' => $userData->name,
                    'email' => $userData->email,
                    'phone' => $userData->phone,
                    'address' => $userData->address,
                ]);
            }
        }
        
        $form->onSuccess[] = [$this, 'processCheckoutForm'];
        
        return $form;
    }
    
    public function processCheckoutForm(Form $form, array $values): void
{
    // Kontrola, zda košík není prázdný
    if (empty($this->cartSession->items)) {
        $this->flashMessage('Váš košík je prázdný.', 'warning');
        $this->redirect('Catalog:default');
    }
    
    try {
        // Kontrola, zda byl zaškrtnut checkbox pro použití existujících údajů
        $useExistingAddress = $this->getHttpRequest()->getPost('useExistingAddress') === 'on';
        
        // Výpočet celkové ceny objednávky
        $totalPrice = 0;
        foreach ($this->cartSession->items as $productId => $quantity) {
            $product = $this->productRepository->getById((int)$productId);
            if ($product) {
                $totalPrice += $product->price * $quantity;
            }
        }
        
        // Příprava dat pro objednávku
        $orderData = [
            'user_id' => $this->getUser()->isLoggedIn() ? $this->getUser()->getId() : null,
            'total_price' => $totalPrice,
            'status' => 'pending',
            'note' => $values['note'],
            'created_at' => (new \DateTime())->format('Y-m-d H:i:s')
        ];
        
        // Pokud je přihlášen uživatel a chce použít existující údaje
        if ($this->getUser()->isLoggedIn() && $useExistingAddress) {
            $userData = $this->userRepository->getById($this->getUser()->getId());
            
            // Ověření, že uživatel má vyplněné údaje
            if (empty($userData->address) || empty($userData->phone)) {
                $this->flashMessage('Pro dokončení objednávky musíte mít vyplněnou adresu a telefon v profilu.', 'warning');
                $this->redirect('User:profile');
            }
            
            // Extra údaje pro objednávku, které nejsou v tabulce orders, ale můžeme je použít jinde
            $deliveryData = [
                'name' => $userData->name,
                'email' => $userData->email,
                'phone' => $userData->phone,
                'address' => $userData->address
            ];
        } else {
            // Použij hodnoty z formuláře
            $deliveryData = [
                'name' => $values['name'],
                'email' => $values['email'],
                'phone' => $values['phone'],
                'address' => $values['address']
            ];
        }
        
        // Vytvoření objednávky
        $orderId = $this->orderRepository->insert($orderData);
        
        // Přidání položek objednávky
        foreach ($this->cartSession->items as $productId => $quantity) {
            $product = $this->productRepository->getById((int)$productId);
            if ($product) {
                $this->orderRepository->addOrderItem([
                    'order_id' => $orderId,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'unit_price' => $product->price
                ]);
                
                // Aktualizace skladu
                $this->productRepository->update((int)$productId, [
                    'stock_quantity' => $product->stock_quantity - $quantity
                ]);
            }
        }
        
        // Vymazání košíku
        $this->cartSession->items = [];
        $this->flashMessage('Vaše objednávka byla úspěšně vytvořena! Děkujeme za nákup.', 'success');

        $this->redirect('Home:default');
        
    } catch (\Nette\Application\AbortException $e) {
        $this->redirect('Home:default');
    } catch (\Exception $e) {
        $this->flashMessage('Při vytváření objednávky došlo k chybě: ' . $e->getMessage(), 'danger');
        $this->redirect('Home:default');
    }
}
}