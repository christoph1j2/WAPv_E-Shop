<?php

declare(strict_types=1);

namespace App\Presentation\Front;

use Nette\Application\UI\Presenter;

class FrontPresenter extends Presenter
{
    public function beforeRender(): void
    {
        $this->setLayout('@layout'); // Ensure this points to Front/@layout.latte
    }

    public function renderDefault(): void
    {
        $this->template->title = "Front Home"; // Optional title
    }
}
