<?php

declare(strict_types=1);

namespace App\Presentation\Admin\Orders;

use App\Presentation\Admin\AdminPresenter;
use App\Presentation\Accessory\Repository\OrderRepository;
use App\Presentation\Accessory\Repository\UserRepository;
use App\Presentation\Accessory\Repository\ProductRepository;
use Nette\Application\UI\Form;
use Nette\Application\BadRequestException;

final class OrdersPresenter extends AdminPresenter
{
    private OrderRepository $orderRepository;
    private UserRepository $userRepository;
    private ProductRepository $productRepository;

    public function __construct(
        OrderRepository $orderRepository,
        UserRepository $userRepository,
        ProductRepository $productRepository
    ) {
        parent::__construct();
        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
    }

    public function renderDefault(): void
    {
        $this->template->orders = $this->orderRepository->getAll();
        $this->template->pageTitle = 'Správa objednávek';
    }

    public function renderDetail(int $id): void
    {
        $order = $this->orderRepository->getById($id);
        
        if (!$order) {
            throw new BadRequestException('Objednávka nebyla nalezena.');
        }
        
        // Načtení položek objednávky
        $orderItems = $this->orderRepository->getOrderItems($id);
        
        // Načtení detailů produktů pro položky objednávky
        $items = [];
        foreach ($orderItems as $item) {
            $product = $this->productRepository->getById((int)$item->product_id);
            $items[] = [
                'item' => $item,
                'product' => $product,
                'total_price' => $item->quantity * $item->unit_price
            ];
        }
        
        // Načtení uživatele, který vytvořil objednávku
        $userData = null;
        if ($order->user_id) {
            $userData = $this->userRepository->getById((int)$order->user_id);
        }
        
        $this->template->order = $order;
        $this->template->items = $items;
        $this->template->userData = $userData;
        $this->template->pageTitle = 'Detail objednávky #' . $id;
    }

    protected function createComponentChangeStatusForm(): Form
    {
        $form = new Form;
        
        $form->addSelect('status', 'Stav objednávky', [
            'pending' => 'Čeká na zpracování',
            'processing' => 'Zpracovává se',
            'shipped' => 'Odesláno',
            'delivered' => 'Doručeno',
            'cancelled' => 'Zrušeno'
        ])
        ->setRequired('Vyberte stav objednávky');
        
        $form->addSubmit('submit', 'Aktualizovat');
        
        $form->onSuccess[] = [$this, 'changeStatusFormSucceeded'];
        
        $orderId = $this->getParameter('id');
        if ($orderId) {
            $order = $this->orderRepository->getById((int)$orderId);
            if ($order) {
                $form->setDefaults([
                    'status' => $order->status
                ]);
            }
        }
        
        return $form;
    }

    public function changeStatusFormSucceeded(Form $form, array $values): void
    {
        $orderId = $this->getParameter('id');
        
        if (!$orderId) {
            $this->flashMessage('Nebyla vybrána žádná objednávka.', 'danger');
            $this->redirect('this');
        }
        
        $this->orderRepository->update((int)$orderId, [
            'status' => $values['status']
        ]);
        
        $this->flashMessage('Stav objednávky byl úspěšně aktualizován.', 'success');
        $this->redirect('this');
    }
}