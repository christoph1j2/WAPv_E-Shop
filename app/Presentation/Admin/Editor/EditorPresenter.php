<?php

declare(strict_types=1);

namespace App\Presentation\Admin\Editor;

use Nette\Application\UI\Presenter;

class EditorPresenter extends Presenter
{
    public function beforeRender(): void
    {
        $this->setLayout('@layout'); // Ensure this points to Front/@layout.latte
    }

}
