<?php

namespace App\Presentation;

use App\Presentation\Accessory\Components\Dummy\DummyComponent;
use App\Presentation\Accessory\Base\BaseComponent;
use Nette\Application\UI\Presenter;

class BasePresenter extends Presenter
{
    protected function createComponentMenu(): ?BaseComponent
    {
        return new DummyComponent("Front page menu");
    }
}