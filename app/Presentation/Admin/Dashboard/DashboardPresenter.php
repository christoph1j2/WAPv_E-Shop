<?php

declare(strict_types=1);

namespace App\Presentation\Admin\Dashboard;

use App\Presentation\Admin\AdminPresenter;
use App\Presentation\Accessory\Repository\ProductRepository;
use App\Presentation\Accessory\Repository\OrderRepository;
use App\Presentation\Accessory\Repository\UserRepository;

final class DashboardPresenter extends AdminPresenter
{
    private ProductRepository $productRepository;
    private OrderRepository $orderRepository;
    private UserRepository $userRepository;

    public function __construct(
        ProductRepository $productRepository,
        OrderRepository $orderRepository,
        UserRepository $userRepository
    ) {
        parent::__construct();
        $this->productRepository = $productRepository;
        $this->orderRepository = $orderRepository;
        $this->userRepository = $userRepository;
    }

    public function renderDefault(): void
    {
        $this->template->pageTitle = 'Admin Dashboard';
        
        // Set initial default values to prevent errors
        $this->template->totalProducts = 0;
        $this->template->totalOrders = 0;
        $this->template->totalUsers = 0;
        $this->template->recentOrders = [];
        $this->template->lowStockProducts = [];
        
        try {
            // Only try to get actual values if repositories have the required methods
            if (method_exists($this->productRepository, 'getTotalCount')) {
                $this->template->totalProducts = $this->productRepository->getTotalCount();
            }
            
            if (method_exists($this->orderRepository, 'getTotalCount')) {
                $this->template->totalOrders = $this->orderRepository->getTotalCount();
            }
            
            if (method_exists($this->userRepository, 'getTotalCount')) {
                $this->template->totalUsers = $this->userRepository->getTotalCount();
            }
            
            if (method_exists($this->orderRepository, 'getRecent')) {
                $this->template->recentOrders = $this->orderRepository->getRecent(5);
            }
            
            if (method_exists($this->productRepository, 'getLowStock')) {
                $this->template->lowStockProducts = $this->productRepository->getLowStock(5);
            }
        } catch (\Exception $e) {
            $this->flashMessage('Došlo k chybě při načítání dat: ' . $e->getMessage(), 'danger');
        }
    }
}