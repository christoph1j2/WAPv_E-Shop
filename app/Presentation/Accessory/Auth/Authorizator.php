<?php
/**
 * Authorizator.php
 * 
 * This file contains the Authorizator class which manages access control
 * for the entire application based on roles and permissions.
 * 
 * @package App\Presentation\Accessory\Auth
 * @version 1.0
 */

declare(strict_types=1);

namespace App\Presentation\Accessory\Auth;

use Nette\Security\Permission;

/**
 * Authorizator Class
 * 
 * Extends Nette's Permission class to implement a Role-Based Access Control (RBAC) system
 * for the application. This class defines all roles, resources, and permission rules
 * that determine which users can access which parts of the application.
 * 
 * The authorization system follows these principles:
 * - Each user has a role (guest, user, editor, admin)
 * - Each role can inherit permissions from another role
 * - Resources represent modules and presenters in the application
 * - Permissions are granted through allow rules
 */
class Authorizator extends Permission
{
    /**
     * Constructor initializes the RBAC system with roles, resources, and permissions.
     * 
     * Sets up the complete authorization structure for the application including:
     * - Role hierarchy
     * - Available resources (presenters/modules)
     * - Access rules for each role
     */
    public function __construct()
    {
        // -------------------------------------------------------------------------
        // Role Definitions
        // -------------------------------------------------------------------------
        
        /**
         * Define the basic roles in the system:
         * - guest: Unauthenticated visitors
         * - user: Registered and logged-in customers
         * - editor: Staff members who can manage products and view orders
         * - admin: Administrators with full access to all system functionality
         */
        $this->addRole('guest');                // Base role for unauthenticated visitors
        $this->addRole('user', 'guest');        // Registered users inherit guest permissions
        $this->addRole('editor', 'user');       // Editors inherit user permissions
        $this->addRole('admin');                // Admins have separate permissions (no inheritance)

        // -------------------------------------------------------------------------
        // Resource Definitions
        // -------------------------------------------------------------------------
        
        /**
         * Define front-end (public) resources
         * Each resource represents a presenter that can have multiple actions
         */
        $this->addResource('Front:Home');       // Homepage functionality
        $this->addResource('Front:Login');      // User authentication
        $this->addResource('Front:Register');   // New user registration
        $this->addResource('Front:User');       // User account management
        $this->addResource('Front:Product');    // Product viewing
        $this->addResource('Front:Cart');       // Shopping cart functionality
        $this->addResource('Front:Order');      // Order processing and history
        $this->addResource('Front:Catalog');    // Product catalog browsing
        
        /**
         * Define back-end (admin) resources
         * Each resource represents an administrative presenter
         */
        $this->addResource('Admin:Home');       // Admin homepage
        $this->addResource('Admin:Dashboard');  // Admin dashboard and statistics
        $this->addResource('Admin:Editor');     // Content management
        $this->addResource('Admin:Products');   // Product management
        $this->addResource('Admin:Users');      // User account management
        $this->addResource('Admin:Orders');     // Order management

        // -------------------------------------------------------------------------
        // Permission Rules
        // -------------------------------------------------------------------------
        
        /**
         * Guest Permissions
         * 
         * Unauthenticated visitors can:
         * - View the homepage
         * - Browse the catalog and product listings
         * - Log in and register
         * - View product details
         * - Reset their password
         */
        $this->allow('guest', 'Front:Home', 'default');
        $this->allow('guest', 'Front:Catalog', ['default', 'detail']);
        $this->allow('guest', 'Front:Login', ['default', 'logout']);
        $this->allow('guest', 'Front:Register', 'default');
        $this->allow('guest', 'Front:Product', ['default', 'detail', 'list']);
        $this->allow('guest', 'Front:User', ['forgotPassword', 'resetPassword', 'logout']);
        
        /**
         * User Permissions
         * 
         * Registered users can additionally:
         * - Manage their profile
         * - Change their password
         * - View their order history
         * - Use the shopping cart
         * - Create and view orders
         */
        $this->allow('user', 'Front:User', ['profile', 'edit', 'changePassword', 'logout', 'orderDetail']);
        $this->allow('user', 'Front:Cart', ['default', 'add', 'remove', 'update', 'checkout']);
        $this->allow('user', 'Front:Order', ['create', 'detail', 'list']);

        /**
         * Editor Permissions
         * 
         * Editors can additionally:
         * - Access the editor section
         * - Manage products (view, edit, add)
         * - View orders and their details
         */
        $this->allow('editor', 'Admin:Editor', 'default');
        $this->allow('editor', 'Admin:Products', ['default', 'edit', 'add']);
        $this->allow('editor', 'Admin:Orders', ['default', 'detail', 'list']);

        /**
         * Admin Permissions
         * 
         * Administrators have:
         * - Full access to all resources and actions
         */
        $this->allow('admin', Permission::All, Permission::All);
        
        /**
         * Universal Permissions
         * 
         * All roles can access:
         * - The logout functionality
         */
        $this->allow(Permission::All, 'Front:User', 'logout');
    }
}