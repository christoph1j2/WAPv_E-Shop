<?php

declare(strict_types=1);

namespace App\Presentation\Accessory\Base;

use Nette\Database\Explorer;

abstract class BaseModel
{
    protected Explorer $database;

    public function __construct(Explorer $database)
    {
        $this->database = $database;
    }
}
