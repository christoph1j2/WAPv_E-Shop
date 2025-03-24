<?php

namespace App\Presentation\Accessory\Components\Dummy;

use App\Presentation\Accessory\Base\BaseComponent;
use Tracy\Debugger;

class DummyComponent extends BaseComponent
{
    /** @var string */
    protected $text;

    public function __construct(string $text)
    {
        $this->text = $text;
    }

    protected function putParametersIntoTemplate(...$parameters)
    {
        $this->template->text = $this->text;
    }
}