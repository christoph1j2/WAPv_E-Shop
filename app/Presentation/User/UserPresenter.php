<?php

declare(strict_types=1);

namespace App\Presentation\User;

use Nette\Application\UI\Presenter;

class UserPresenter extends Presenter
{
    public function beforeRender(): void
    {
        $this->setLayout('@layout'); // Ensure this points to Front/@layout.latte
    }

}
