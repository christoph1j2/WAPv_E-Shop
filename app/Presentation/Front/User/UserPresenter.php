<?php

declare(strict_types=1);

namespace App\Presentation\Front\User;

use App\Presentation\Auth\AuthService;
use App\Presentation\Accessory\Repository\UserRepository;
use App\Presentation\Accessory\Repository\OrderRepository;
use App\Presentation\Accessory\Repository\ProductRepository;
use App\Presentation\Front\FrontPresenter;
use Nette\Application\UI\Form;

final class UserPresenter extends FrontPresenter
{
    private AuthService $authService;
    private UserRepository $userRepository;
    private OrderRepository $orderRepository;
    private ProductRepository $productRepository;

    public function __construct(AuthService $authService, UserRepository $userRepository, OrderRepository $orderRepository, ProductRepository $productRepository)
    {
        parent::__construct();
        $this->authService = $authService;
        $this->userRepository = $userRepository;
        $this->orderRepository = $orderRepository;
        $this->productRepository = $productRepository;
    }

    public function startup(): void
    {
        parent::startup();

        // Kromě akce forgotPassword, resetPassword a logout musí být uživatel přihlášen
        if (!in_array($this->getAction(), ['forgotPassword', 'resetPassword', 'logout']) && !$this->getUser()->isLoggedIn()) {
            $this->flashMessage('Pro přístup do této sekce musíte být přihlášeni.', 'warning');
            $this->redirect('Login:default');
        }
    }

    public function renderProfile(): void
    {
        $this->template->pageTitle = 'Můj profil';
        
        // Načtení dat uživatele z databáze
        $userId = $this->getUser()->getId();
        $userData = $this->userRepository->getById($userId);
        $this->template->userData = $userData;
        
        // Načtení objednávek uživatele
        $orders = $this->orderRepository->getOrdersByUser($userId);
        $this->template->orders = $orders;
    }

    protected function createComponentEditForm(): Form
    {
        $form = new Form();
        $user = $this->getUser()->getIdentity();

        $form->addText('phone', 'Telefon:')
            ->setDefaultValue($user->phone)
            ->setRequired('Zadejte telefon.');

        $form->addTextArea('address', 'Adresa:')
            ->setDefaultValue($user->address)
            ->setRequired('Zadejte adresu.');

        $form->addSubmit('submit', 'Uložit změny');
        $form->onSuccess[] = [$this, 'processEdit'];
        return $form;
    }

    public function processEdit(Form $form, array $values): void
    {
        if (!$this->getUser()->isLoggedIn()) {
            $this->flashMessage("Pro úpravu profilu se prosím přihlaste.", "danger");
            $this->redirect('Login:default');
            return;
        }
        
        $identity = $this->getUser()->getIdentity();
        $userId = $identity->id;
        
        // 1. Aktualizujte pouze databázi
        $this->userRepository->update($userId, [
            'phone'   => $values['phone'],
            'address' => $values['address'],
        ]);
        
        // 2. Nastavte flash zprávu
        $this->flashMessage('Profil byl aktualizován.', 'success');
        
        // 3. Přesměrování na profil
        $this->redirect('profile');
    }



    public function renderChangePassword(): void
    {
        if (!$this->getUser()->isLoggedIn()) {
            $this->flashMessage("Pro změnu hesla se prosím přihlaste.", "warning");
            $this->redirect('Login:default');
        }
        $this->template->pageTitle = 'Změna hesla';
    }

    protected function createComponentChangePasswordForm(): Form
    {
        $form = new Form();
        
        $form->addPassword('current_password', 'Aktuální heslo:')
             ->setRequired('Zadejte aktuální heslo.')
             ->getControlPrototype()->addClass('form-control');
             
        $form->addPassword('new_password', 'Nové heslo:')
             ->setRequired('Zadejte nové heslo.')
             ->getControlPrototype()->addClass('form-control');
             
        $form->addPassword('confirm_password', 'Potvrďte nové heslo:')
             ->setRequired('Potvrďte nové heslo.')
             ->addRule(Form::Equal, 'Hesla se neshodují.', $form['new_password'])
             ->getControlPrototype()->addClass('form-control');
        
        $form->addSubmit('submit', 'Změnit heslo')
             ->getControlPrototype()->addClass('btn btn-warning mt-2');
        
        $form->onSuccess[] = [$this, 'processChangePassword'];
        return $form;
    }
    
    public function processChangePassword(Form $form, array $values): void
    {
        if (!$this->getUser()->isLoggedIn()) {
            $this->flashMessage("Pro změnu hesla se prosím přihlaste.", "warning");
            $this->redirect('Login:default');
        }
        
        $identity = $this->getUser()->getIdentity();
        $userId = $identity->id;
        
        try {
            // Verifikujte aktuální heslo a změňte na nové
            $this->authService->changePassword(
                $userId, 
                $values['current_password'], 
                $values['new_password']
            );
            
            $this->flashMessage('Heslo bylo úspěšně změněno.', 'success');
            $this->redirect('profile');
        } catch (\Exception $e) {
            $form->addError($e->getMessage());
        }
    }

    public function actionLogout(): void
    {
        // Get access to the cart session before logging out
        $session = $this->getSession();
        $cartSession = $session->getSection('cart');
        
        // First logout the user
        if ($this->getUser()->isLoggedIn()) {
            $this->getUser()->logout();
            
            // Then clear the cart contents
            if (isset($cartSession->items)) {
                $cartSession->items = []; // Empty the cart
            }
            
            $this->flashMessage('Byli jste úspěšně odhlášeni.', 'success');
        }
        
        $this->redirect('Home:default');
    }

    public function renderForgotPassword(): void
    {
        $this->template->pageTitle = 'Zapomenuté heslo';
    }

    public function renderResetPassword(string $token = null): void
{
    if (!$token) {
        $this->flashMessage('Neplatný odkaz pro obnovu hesla.', 'danger');
        $this->redirect('Login:default');
    }
    
    $this->template->pageTitle = 'Obnovení hesla';
    $this->template->token = $token;
}

    protected function createComponentForgotPasswordForm(): Form
    {
        $form = new Form();
        
        $form->addEmail('email', 'Váš e-mail:')
            ->setRequired('Zadejte e-mail, který jste použili při registraci.')
            ->getControlPrototype()->addClass('form-control');
        
        $form->addSubmit('submit', 'Odeslat žádost')
            ->getControlPrototype()->addClass('btn btn-primary mt-2');
        
        $form->onSuccess[] = [$this, 'processForgotPassword'];
        return $form;
    }

    protected function createComponentResetPasswordForm(): Form
    {
        $form = new Form();
        
        $form->addHidden('token', $this->getParameter('token'));
        
        $form->addPassword('new_password', 'Nové heslo:')
            ->setRequired('Zadejte nové heslo.')
            ->getControlPrototype()->addClass('form-control');
            
        $form->addPassword('confirm_password', 'Potvrďte nové heslo:')
            ->setRequired('Potvrďte nové heslo.')
            ->addRule(Form::Equal, 'Hesla se neshodují.', $form['new_password'])
            ->getControlPrototype()->addClass('form-control');
        
        $form->addSubmit('submit', 'Nastavit nové heslo')
            ->getControlPrototype()->addClass('btn btn-primary mt-2');
        
        $form->onSuccess[] = [$this, 'processResetPassword'];
        return $form;
    }

    public function processForgotPassword(Form $form, array $values): void
    {
        $email = $values['email'];
        
        // Generate token
        $token = $this->authService->requestPasswordReset($email);
        
        if ($token) {
            // In a real application, you would send an email with a reset link
            // For this example, we'll just show it in the flash message
            $resetLink = $this->link('//User:resetPassword', ['token' => $token]);
            $this->flashMessage("Odkaz pro obnovu hesla byl odeslán na váš e-mail: $resetLink", 'success');
            $this->redirect('Login:default');
        } else {
            $form->addError('E-mail nebyl nalezen v naší databázi.');
        }
    }

    public function processResetPassword(Form $form, array $values): void
    {
        $token = $values['token'];
        $newPassword = $values['new_password'];
        
        $success = $this->authService->resetPassword($token, $newPassword);
        
        if ($success) {
            $this->flashMessage('Vaše heslo bylo úspěšně změněno. Nyní se můžete přihlásit.', 'success');
            $this->redirect('Login:default');
        } else {
            $form->addError('Odkaz pro obnovu hesla je neplatný nebo vypršel.');
        }
    }

    public function renderOrders(): void
    {
        if (!$this->getUser()->isLoggedIn()) {
            $this->flashMessage("Pro zobrazení objednávek se prosím přihlaste.", "warning");
            $this->redirect('Login:default');
        }
        
        $userId = $this->getUser()->getIdentity()->id;
        $orders = $this->userRepository->findOrders($userId);
        
        $this->template->pageTitle = 'Moje objednávky';
        $this->template->orders = $orders;
    }

    /**
     * Zobrazí detail objednávky
     */
    public function renderOrderDetail(int $id): void
    {
        // Získání objednávky z databáze
        $order = $this->orderRepository->getById($id);
        
        // Kontrola existence objednávky
        if (!$order) {
            $this->flashMessage('Objednávka nebyla nalezena.', 'danger');
            $this->redirect('profile');
        }
        
        // Kontrola, zda objednávka patří přihlášenému uživateli
        if ($order->user_id !== $this->getUser()->getId() && !$this->getUser()->isInRole('admin')) {
            $this->flashMessage('Nemáte oprávnění k zobrazení této objednávky.', 'danger');
            $this->redirect('profile');
        }
        
        // Načtení položek objednávky
        $orderItems = $this->orderRepository->getOrderItems($id);
        
        // Načtení detailů produktů pro položky objednávky
        $items = [];
        foreach ($orderItems as $item) {
            $product = $this->productRepository->getById($item->product_id);
            $items[] = [
                'item' => $item,
                'product' => $product,
                'total_price' => $item->quantity * $item->unit_price
            ];
        }
        
        $this->template->order = $order;
        $this->template->items = $items;
        $this->template->pageTitle = 'Detail objednávky #' . $id;
    }

    
}
