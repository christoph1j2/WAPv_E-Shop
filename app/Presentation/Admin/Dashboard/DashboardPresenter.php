<?php

declare(strict_types=1);

namespace App\Presentation\Admin\Dashboard;

use Nette\Application\UI\Presenter;

class DashboardPresenter extends Presenter
{
    public function beforeRender(): void
    {
        $this->setLayout('@layout'); // Ensure this points to Front/@layout.latte
    }

}
