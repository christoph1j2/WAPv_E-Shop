<?php

declare(strict_types=1);

namespace App\Presentation\Front\Catalog;

use Nette\Application\UI\Presenter;

class CatalogPresenter extends Presenter
{
    public function beforeRender(): void
    {
        $this->setLayout('@layout'); // Ensure this points to Front/@layout.latte
    }

}
