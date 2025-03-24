<?php
/**
 * RouterFactory.php
 * 
 * This file contains the RouterFactory class which is responsible for creating
 * and configuring the application's router.
 * 
 * @package App\Core
 * @version 1.0
 */

declare(strict_types=1);

namespace App\Core;

use Nette;
use Nette\Application\Routers\RouteList;

/**
 * RouterFactory Class
 * 
 * This class is responsible for creating the application's router configuration.
 * It defines all routes for both Admin and Front modules.
 * 
 * The router is created as a RouteList, which is a collection of routes.
 * Routes are matched in the order they are added, with the first matching route being used.
 */
final class RouterFactory
{
    /**
     * Uses Nette's StaticClass trait to prevent instantiation of this class
     * as it only contains static methods.
     */
    use Nette\StaticClass;

    /**
     * Creates and configures the application router.
     * 
     * This method defines all routes for the application, organizing them by module.
     * The router follows a hierarchical structure with two main modules:
     * - Admin module: Contains routes for administrative functions
     * - Front module: Contains routes for public-facing functionality
     * 
     * @return RouteList A configured router with all application routes
     */
    public static function createRouter(): RouteList
    {
        $router = new RouteList;

        // Admin Module Routes
        // These routes handle all administrative functionality
        $router->withModule('Admin')
            // Generic route for all admin pages with format: admin/presenter/action/id
            ->addRoute('admin/<presenter>/<action>[/<id>]', '<presenter>:default')
            // Commented out route
            //->addRoute('<presenter>/<action>[/<id>]', 'Home:default')
            ->end();

        // Front Module Routes
        // These routes handle all public-facing functionality
        $router->withModule('Front')
            // User authentication routes
            ->addRoute('logout', 'User:logout')                           // User logout functionality
            ->addRoute('user/forgotPassword', 'User:forgotPassword')      // Password recovery process
            ->addRoute('user/changePassword', 'User:changePassword')      // Password change functionality
            
            // User account routes
            ->addRoute('user/orderDetail/<id>', 'User:orderDetail')       // Order details view
            ->addRoute('user/<action>[/<id>]', 'User:profile')            // User profile actions
            
            // Catalog routes
            ->addRoute('catalog/product/<id>', 'Catalog:detail')          // Product detail page
            
            // Default route - catches all other URLs
            ->addRoute('<presenter>/<action>[/<id>]', 'Home:default')     // Default fallback route
            ->end();

        return $router;
    }
}
