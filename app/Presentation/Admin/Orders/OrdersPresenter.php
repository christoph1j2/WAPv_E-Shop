<?php

declare(strict_types=1);

namespace App\Presentation\Admin\Orders;

use App\Presentation\Admin\AdminPresenter;
use App\Presentation\Accessory\Repository\OrderRepository;
use App\Presentation\Accessory\Repository\UserRepository;
use App\Presentation\Accessory\Repository\ProductRepository;
use Nette\Application\UI\Form;
use Nette\Application\BadRequestException;
use Ublaboo\DataGrid\DataGrid;

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
        $this->template->pageTitle = 'Správa objednávek';
        // Orders are loaded by DataGrid - no need for template->orders anymore
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

    /**
     * Signal handler for changing order status from DataGrid
     */
    public function handleChangeStatus(int $id, string $status): void
    {
        // Validate the order exists
        $order = $this->orderRepository->getById($id);
        if (!$order) {
            $this->flashMessage('Objednávka nebyla nalezena.', 'danger');
            $this->redirect('default');
        }
        
        // Validate status value
        $validStatuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
        if (!in_array($status, $validStatuses)) {
            $this->flashMessage('Neplatný stav objednávky.', 'danger');
            $this->redirect('default');
        }
        
        try {
            // Update order status
            $this->orderRepository->update($id, [
                'status' => $status
            ]);
            
            $this->flashMessage('Stav objednávky #' . $id . ' byl úspěšně změněn na "' . 
                $this->getStatusLabel($status) . '".', 'success');
            
            if ($this->isAjax()) {
                $this->redrawControl('flashes');
                // Redraw just the specific row instead of reloading the whole grid
                $this['ordersGrid']->redrawItem($id);
            } else {
                $this->redirect('default');
            }
        } catch (\Exception $e) {
            $this->flashMessage('Chyba při změně stavu: ' . $e->getMessage(), 'danger');
            $this->redirect('default');
        }
    }

    /**
     * Get human-readable status label
     */
    private function getStatusLabel(string $status): string
    {
        $statusLabels = [
            'pending' => 'Čeká na zpracování',
            'processing' => 'Zpracovává se',
            'shipped' => 'Odesláno',
            'delivered' => 'Doručeno',
            'cancelled' => 'Zrušeno'
        ];
        
        return $statusLabels[$status] ?? $status;
    }

    protected function createComponentOrdersGrid(): DataGrid
    {
        $grid = new DataGrid();
        $grid->setPrimaryKey('id');

        //$grid->setAjaxRequest();

        // Data source
        $grid->setDataSource($this->orderRepository->getAll());

        // Columns
        $grid->addColumnText('id', 'Číslo obj.')
            ->setSortable()
            ->setFilterText()
            ;

        $grid->addColumnDateTime('created_at', 'Datum vytvoření')
            ->setFormat('d.m.Y H:i')
            ->setSortable()
            // ->setFilterDateRange()
            ;

        $grid->addColumnText('total_price', 'Celková cena')
            ->setRenderer(function ($row) {
                return number_format($row->total_price, 2, ',', ' ') . ' Kč';
            })
            ->setSortable()
            ->setFilterRange();


        // Customer column - renders name from users table
        $grid->addColumnText('user_id', 'Zákazník')
            ->setRenderer(function($item) {
                if ($item->user_id) {
                    $user = $this->userRepository->getById((int)$item->user_id);
                    return $user ? $user->name : 'Neznámý';
                }
                return 'Host';
            })
            ->setSortable()
            ->setFilterText();
            // ->setEscaping(false);

        // Status column with both text and select filter
        $statusOptions = [
            'pending' => 'Čeká na zpracování',
            'processing' => 'Zpracovává se',
            'shipped' => 'Odesláno',
            'delivered' => 'Doručeno',
            'cancelled' => 'Zrušeno'
        ];
        
        $grid->addColumnStatus('status', 'Stav')
            ->setSortable()
            ->addOption('pending', 'Čeká na zpracování')
                ->setClass('btn-warning')
                ->endOption()
            ->addOption('processing', 'Zpracovává se')
                ->setClass('btn-info')
                ->endOption()
            ->addOption('shipped', 'Odesláno')
                ->setClass('btn-primary')
                ->endOption()
            ->addOption('delivered', 'Doručeno')
                ->setClass('btn-success')
                ->endOption()
            ->addOption('cancelled', 'Zrušeno')
                ->setClass('btn-danger')
                ->endOption()
            ->onChange[] = [$this, 'changeOrderStatus'];
            
        // $grid->getColumn('status')->setFilterSelect([
        //     '' => 'Všechny',
        //     'pending' => 'Čeká na zpracování',
        //     'processing' => 'Zpracovává se',
        //     'shipped' => 'Odesláno',
        //     'delivered' => 'Doručeno',
        //     'cancelled' => 'Zrušeno'
        // ]);

        // Actions
        $grid->addAction('detail', 'Detail', 'detail')
            ->setIcon('eye')
            ->setClass('btn btn-sm btn-primary');

        return $grid;
    }

    /**
     * Callback for status change in DataGrid
     */
    public function changeOrderStatus(int $id, string $status): void
    {
        $this->redirect('changeStatus!', ['id' => $id, 'status' => $status]);
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