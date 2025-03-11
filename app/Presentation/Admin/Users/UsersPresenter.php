<?php

declare(strict_types=1);

namespace App\Presentation\Admin\Users;

use Nette\Application\UI\Presenter;

class UsersPresenter extends Presenter
{
    public function beforeRender(): void
    {
        $this->setLayout('@layout'); // Ensure this points to Front/@layout.latte
    }

}
