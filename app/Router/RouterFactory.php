<?php

declare(strict_types=1);

namespace App\Router;

use Nette;
use Nette\Application\Routers\RouteList;

final class RouterFactory
{
    use Nette\StaticClass;

    public static function createRouter(): RouteList
    {
        $router = new RouteList;

        // Front module routes
        $router->addRoute('<presenter>/<action>[/<id>]', [
            'module' => 'Front',
            'presenter' => 'Homepage',
            'action' => 'default',
        ]);

        return $router;
    }
}
