<?php

declare(strict_types=1);

namespace App\Presentation\Admin\Products;

use App\Presentation\Admin\AdminPresenter;
use App\Presentation\Accessory\Repository\ProductRepository;
use App\Presentation\Accessory\Repository\CategoryRepository;
use Nette\Application\UI\Form;
use Ublaboo\DataGrid\DataGrid;

final class ProductsPresenter extends AdminPresenter
{
    private ProductRepository $productRepository;
    private CategoryRepository $categoryRepository;
    
    public function __construct(
        ProductRepository $productRepository,
        CategoryRepository $categoryRepository
    ) {
        parent::__construct();
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function renderDefault(): void
    {
        $this->template->pageTitle = 'Správa produktů';
        $this->template->products = $this->productRepository->getAll();
    }

    public function renderAdd(): void
    {
        $this->template->pageTitle = 'Přidat nový produkt';
    }

    public function renderEdit(int $id): void
    {
        $product = $this->productRepository->getById($id);
        
        if (!$product) {
            $this->flashMessage('Produkt nebyl nalezen.', 'danger');
            $this->redirect('default');
        }
        
        $this->template->product = $product;
        $this->template->pageTitle = 'Upravit produkt: ' . $product->name;
        
        // Nastavení výchozích hodnot formuláře
        $this['productForm']->setDefaults([
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price,
            'stock_quantity' => $product->stock_quantity,
            'category_id' => $product->category_id,
        ]);
    }
    
    // public function actionDelete(int $id): void
    // {
    //     $product = $this->productRepository->getById($id);
        
    //     if (!$product) {
    //         $this->flashMessage('Produkt nebyl nalezen.', 'danger');
    //         $this->redirect('default');
    //     }
        
    //     // Smazání produktu z databáze
    //     $this->productRepository->delete($id);
        
    //     $this->flashMessage('Produkt byl úspěšně smazán.', 'success');
    //     $this->redirect('default');
    // }

    /**
     * Signal handler for delete action from DataGrid
     */
    public function handleDelete(int $id): void
    {
        $product = $this->productRepository->getById($id);
        
        if (!$product) {
            $this->flashMessage('Produkt nebyl nalezen.', 'danger');
            $this->redirect('default');
        }
        
        // Smazání produktu z databáze
        $this->productRepository->delete($id);
        
        $this->flashMessage('Produkt byl úspěšně smazán.', 'success');
        $this->redirect('default');
    }

    protected function createComponentProductForm(): Form
    {
        $form = new Form;
        
        $form->addText('name', 'Název produktu:')
            ->setRequired('Zadejte název produktu.');
            
        $form->addTextArea('description', 'Popis:')
            ->setRequired('Zadejte popis produktu.');
            
        $form->addText('price', 'Cena:')
            ->setRequired('Zadejte cenu produktu.')
            ->addRule($form::FLOAT, 'Cena musí být číslo.');
            
        $form->addInteger('stock_quantity', 'Počet kusů na skladě:')
            ->setDefaultValue(0)
            ->addRule($form::MIN, 'Počet kusů nemůže být záporný.', 0);
            
        $categoriesData = $this->categoryRepository->getAll();
        $categories = [];
        foreach ($categoriesData as $category) {
            $categories[$category->id] = $category->name;
        }
        $form->addSelect('category_id', 'Kategorie:', $categories)
            ->setPrompt('Zvolte kategorii')
            ->setRequired('Zvolte kategorii produktu.');
            
        // Remove image upload field completely
        
        $form->addSubmit('submit', 'Uložit');
        
        $form->onSuccess[] = [$this, 'processProductForm'];
        
        return $form;
    }
    
    public function processProductForm(Form $form, array $values): void
    {
        $id = $this->getParameter('id');
        
        $productData = [
            'name' => $values['name'],
            'description' => $values['description'],
            'price' => $values['price'],
            'stock_quantity' => $values['stock_quantity'],
            'category_id' => $values['category_id'],
        ];
        
        // Zde není potřeba zpracovávat obrázek, protože jsme to odstranili
        
        if ($id) {
            // Aktualizace existujícího produktu - přetypování id na int
            $this->productRepository->update((int)$id, $productData);
            $this->flashMessage('Produkt byl úspěšně aktualizován.', 'success');
        } else {
            // Přidání nového produktu
            $this->productRepository->insert($productData);
            $this->flashMessage('Produkt byl úspěšně přidán.', 'success');
        }
        
        $this->redirect('default');
    }

    protected function createComponentProductsGrid(): DataGrid
    {
        $grid = new DataGrid();
        $grid->setPrimaryKey('id');

        // Data source - using an array or Dibi/Doctrine/Nette\Database
        $grid->setDataSource($this->productRepository->getAll());

        // Columns
        $grid->addColumnText('name', 'Název')
            ->setSortable()
            ->setFilterText();

        $grid->addColumnText('price', 'Cena')
            ->setSortable()
            ->setFilterRange();

        $grid->addColumnText('stock_quantity', 'Skladem')
            ->setSortable()
            ->setFilterRange();

        $grid->addColumnText('category_id', 'Kategorie')
            ->setRenderer(function ($item) {
                return $item->ref('categories', 'category_id')->name;
            });

        // Actions (Edit & Delete)
        $grid->addAction('edit', 'Upravit', 'edit')
            ->setIcon('edit')
            ->setClass('btn btn-sm btn-primary');

        $grid->addAction('delete', 'Smazat', 'delete!')
            ->setIcon('trash')
            ->setClass('btn btn-sm btn-danger')
            ->setConfirmation(new \Ublaboo\DataGrid\Column\Action\Confirmation\StringConfirmation('Opravdu chcete smazat tento produkt?'));

        return $grid;
    }
}