<?php

declare(strict_types=1);

namespace App\Presentation\Admin\Editor;

use App\Presentation\Admin\AdminPresenter;
use App\Presentation\Accessory\Repository\ProductRepository;
use App\Presentation\Accessory\Repository\OrderRepository;

final class EditorPresenter extends AdminPresenter
{
    private ProductRepository $productRepository;
    private OrderRepository $orderRepository;

    public function __construct(
        ProductRepository $productRepository,
        OrderRepository $orderRepository
    ) {
        parent::__construct();
        $this->productRepository = $productRepository;
        $this->orderRepository = $orderRepository;
    }

    public function renderDefault(): void
    {
        $this->template->pageTitle = 'Editor Dashboard';
        
        // Get count of products and recent products for the dashboard
        $this->template->totalProducts = $this->productRepository->getTotalCount();
        $this->template->recentProducts = $this->productRepository->getRecent(5);
        
        // Get recent orders for display
        $this->template->recentOrders = $this->orderRepository->getRecent(5);
    }
    
    public function startup(): void
    {
        parent::startup();
        
        // Ensure the user has editor permissions
        if (!$this->getUser()->isInRole('editor') && !$this->getUser()->isInRole('admin')) {
            $this->flashMessage('Pro přístup do editační sekce nemáte dostatečná oprávnění.', 'danger');
            $this->redirect('Front:Home:default');
        }
    }
}