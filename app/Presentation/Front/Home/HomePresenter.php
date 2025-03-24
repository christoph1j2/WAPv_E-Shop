<?php

declare(strict_types=1);

namespace App\Presentation\Front\Home;

use App\Presentation\Front\FrontPresenter;

final class HomePresenter extends FrontPresenter
{
    public function renderDefault(): void
    {
        $this->template->pageTitle = 'Domovská stránka';
    }
}
