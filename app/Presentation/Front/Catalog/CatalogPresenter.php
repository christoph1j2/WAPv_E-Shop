<?php

declare(strict_types=1);

namespace App\Presentation\Front\Catalog;

use App\Presentation\Front\FrontPresenter;
use App\Presentation\Accessory\Repository\ProductRepository;

final class CatalogPresenter extends FrontPresenter
{
    private ProductRepository $productRepository;
    
    public function __construct(ProductRepository $productRepository)
    {
        parent::__construct();
        $this->productRepository = $productRepository;
    }

    public function renderDefault(): void
    {
        $this->template->products = $this->productRepository->getAll();
    }
    
    public function renderDetail(int $id): void
    {
        $product = $this->productRepository->getById($id);
        
        if (!$product) {
            $this->flashMessage('Produkt nebyl nalezen.', 'danger');
            $this->redirect('default');
        }
        
        $this->template->product = $product;
    }
}