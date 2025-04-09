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

        // Data source
        $grid->setDataSource($this->productRepository->getAll());

        // Columns s inline editací - opravené pořadí metod
        $grid->addColumnText('name', 'Název')
            ->setEditableCallback(function($id, $value) {
                try {
                    $this->productRepository->update((int)$id, ['name' => $value]);
                    return $value;
                } catch (\Exception $e) {
                    return false;
                }
            })
            ->setSortable();
        $grid->addFilterText('name', 'Název:');

        $grid->addColumnText('description', 'Popis')
            ->setEditableCallback(function($id, $value) {
                try {
                    $this->productRepository->update((int)$id, ['description' => $value]);
                    return $value;
                } catch (\Exception $e) {
                    return false;
                }
            });

        $grid->addColumnText('price', 'Cena')
            ->setEditableCallback(function($id, $value) {
                if (!is_numeric($value)) {
                    return false;
                }
                try {
                    $this->productRepository->update((int)$id, ['price' => (float)$value]);
                    return $value;
                } catch (\Exception $e) {
                    return false;
                }
            })
            ->setSortable();
        $grid->addFilterRange('price', 'Cena:');

        $grid->addColumnText('stock_quantity', 'Skladem')
            ->setEditableCallback(function($id, $value) {
                if (!is_numeric($value) || (int)$value < 0) {
                    return false;
                }
                try {
                    $this->productRepository->update((int)$id, ['stock_quantity' => (int)$value]);
                    return $value;
                } catch (\Exception $e) {
                    return false;
                }
            })
            ->setSortable();
        $grid->addFilterRange('stock_quantity', 'Skladem:');

        // Získání kategorií pro select box
        $categoriesData = $this->categoryRepository->getAll();
        $categories = [];
        foreach ($categoriesData as $category) {
            $categories[$category->id] = $category->name;
        }

        $grid->addColumnStatus('category_id', 'Kategorie')
            ->setOptions($categories)
            ->onChange[] = [$this, 'productCategoryChange'];

        // Přidání filtrování pro kategorie
        $grid->addFilterSelect('category_id', 'Kategorie:', ['' => '-- Vše --'] + $categories);

        // Actions (Edit & Delete)
        // $grid->addAction('edit', 'Upravit', 'edit')
        //     ->setIcon('edit')
        //     ->setClass('btn btn-sm btn-primary');

        $grid->addAction('delete', 'Smazat', 'delete!')
            ->setIcon('trash')
            ->setClass('btn btn-sm btn-danger')
            ->setConfirmation(new \Ublaboo\DataGrid\Column\Action\Confirmation\StringConfirmation('Opravdu chcete smazat tento produkt?'));
        
        // Inline přidávání (add)
        $grid->addInlineAdd()
            ->setPositionTop()
            ->onControlAdd[] = function($container) use ($categories) {
                $container->addText('name', '')
                    ->setRequired('Zadejte název produktu')
                    ->setHtmlAttribute('placeholder', 'Název produktu');
                    
                $container->addText('description', '')
                    ->setRequired('Zadejte popis produktu')
                    ->setHtmlAttribute('placeholder', 'Popis produktu');
                
                $container->addText('price', '')
                    ->setRequired('Zadejte cenu produktu')
                    ->addRule(\Nette\Forms\Form::FLOAT, 'Cena musí být číslo')
                    ->setHtmlAttribute('placeholder', 'Cena');
                    
                $container->addInteger('stock_quantity', '')
                    ->setDefaultValue(0)
                    ->addRule(\Nette\Forms\Form::MIN, 'Počet kusů nemůže být záporný', 0)
                    ->setHtmlAttribute('placeholder', 'Počet kusů');
                    
                $container->addSelect('category_id', '', $categories)
                    ->setPrompt('Zvolte kategorii')
                    ->setRequired('Zvolte kategorii produktu');
            };
            
        $grid->getInlineAdd()->onSubmit[] = function($values) {
            try {
                $productData = [
                    'name' => $values['name'],
                    'description' => $values['description'],
                    'price' => $values['price'],
                    'stock_quantity' => $values['stock_quantity'],
                    'category_id' => $values['category_id'],
                ];
                
                $this->productRepository->insert($productData);
                $this->flashMessage('Produkt byl úspěšně přidán', 'success');
                return true;
            } catch (\Exception $e) {
                $this->flashMessage('Při ukládání produktu došlo k chybě: ' . $e->getMessage(), 'danger');
                return false;
            }
        };

        // Nastavení stránkování
        $grid->setPagination(true);
        $grid->setItemsPerPageList([10, 20, 50, 100]);
        
        return $grid;
    }

    public function productCategoryChange($id, $newCategoryId): void
{
    try {
        $this->productRepository->update((int)$id, ['category_id' => $newCategoryId]);
        $this->flashMessage('Kategorie byla změněna', 'success');
        
        if ($this->isAjax()) {
            $this->redrawControl('flashes');
            // Toto je klíčové - explicitně znovu vykreslíme změněný řádek v gridu
            $this['productsGrid']->redrawItem($id);
        } else {
            $this->redirect('this');
        }
    } catch (\Exception $e) {
        $this->flashMessage('Při změně kategorie došlo k chybě: ' . $e->getMessage(), 'danger');
        
        if ($this->isAjax()) {
            $this->redrawControl('flashes');
        } else {
            $this->redirect('this');
        }
    }
}
}