<?php

declare(strict_types=1);

namespace App\Presentation\Front\Cart;

use Nette\Application\UI\Presenter;

class CartPresenter extends Presenter
{
    public function beforeRender(): void
    {
        $this->setLayout('@layout'); // Ensure this points to Front/@layout.latte
    }

}
