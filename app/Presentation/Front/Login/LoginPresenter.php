<?php
/**
 * LoginPresenter.php
 * 
 * This file contains the LoginPresenter class which manages user authentication
 * in the front-end module of the application.
 * 
 * @package App\Presentation\Front\Login
 * @version 1.0
 */

declare(strict_types=1);

namespace App\Presentation\Front\Login;

use App\Presentation\Auth\AuthService;
use App\Presentation\Front\FrontPresenter;
use Nette\Application\UI\Form;
use Nette\Security\AuthenticationException;

/**
 * LoginPresenter Class
 * 
 * Handles user authentication in the front-end module, including:
 * - Login form presentation and handling
 * - User authentication via AuthService
 * - Role-based redirection after successful login
 * - Error handling for authentication failures
 * 
 * This presenter is the entry point for user authentication and provides
 * appropriate user feedback for authentication outcomes.
 */
final class LoginPresenter extends FrontPresenter
{
    /**
     * @var AuthService Authentication service that handles credential verification
     */
    private AuthService $authService;

    /**
     * Constructor initializes the LoginPresenter with required dependencies
     * 
     * @param AuthService $authService Service for authenticating user credentials
     */
    public function __construct(AuthService $authService)
    {
        parent::__construct();
        $this->authService = $authService;
    }

    /**
     * Creates and configures the login form component
     * 
     * Defines form fields, validation rules, and event handlers:
     * - Email field with required validation
     * - Password field with required validation
     * - Submit button
     * - Success handler for form submission
     * 
     * @return Form Configured login form ready for rendering
     */
    protected function createComponentLoginForm(): Form
    {
        $form = new Form();
        $form->addEmail('email', 'E-mail:')
            ->setRequired('Zadejte svůj e-mail.');
        $form->addPassword('password', 'Heslo:')
            ->setRequired('Zadejte své heslo.');
        $form->addSubmit('submit', 'Přihlásit se');
        $form->onSuccess[] = [$this, 'processLogin'];
        return $form;
    }

    /**
     * Processes the login form submission
     * 
     * This method:
     * 1. Authenticates user credentials via AuthService
     * 2. Creates an appropriate identity with role information
     * 3. Logs the user in using Nette's authentication system
     * 4. Provides feedback via flash messages
     * 5. Redirects to role-appropriate destination
     * 6. Handles authentication errors with user-friendly messages
     * 
     * @param Form $form The login form
     * @param array $values Form values submitted by the user (email and password)
     * @return void
     */
    public function processLogin(Form $form, array $values): void
    {
        try {
            // Authenticate user with provided credentials
            $userData = $this->authService->login($values['email'], $values['password']);
            
            // Determine the user's role based on database flags
            $role = 'user'; // Default role for regular users
            if ($userData['is_admin']) {
                $role = 'admin'; // Administrator role with full privileges
            } elseif (isset($userData['is_editor']) && $userData['is_editor']) {
                $role = 'editor'; // Editor role with content management privileges
            }
            
            // Create identity with the determined role
            // Identity contains user ID, roles, and additional user data
            $identity = new \Nette\Security\Identity($userData['id'], [$role], $userData);
            $this->getUser()->login($identity);
            
            // Provide feedback about successful authentication
            $this->flashMessage('Úspěšně přihlášen!', 'success');
            
            // Redirect user to appropriate destination based on role
            if ($role === 'admin') {
                // Administrators go to the admin dashboard
                $this->redirect(':Admin:Dashboard:default');
            } elseif ($role === 'editor') {
                // Editors go to the content management interface
                $this->redirect(':Admin:Editor:default');
            } else {
                // Regular users go to their profile page
                $this->redirect('User:profile');
            }
        } catch (AuthenticationException $e) {
            // Handle authentication failures with user-friendly error messages
            // Add the error message directly to the form for display
            $form->addError($e->getMessage());
            
            // Alternative approaches (commented out):
            // For field-specific errors:
            // $form['email']->addError($e->getMessage());
            
            // For flash messages instead of form errors:
            // $this->flashMessage($e->getMessage(), 'danger');
        }
    }
    
    /**
     * Default action for the login presenter
     * 
     * Handles the initial display of the login page.
     * Redirects already authenticated users to their appropriate destination.
     * 
     * @return void
     */
    public function actionDefault(): void
    {
        // If user is already logged in, redirect them appropriately
        if ($this->getUser()->isLoggedIn()) {
            $roles = $this->getUser()->getRoles();
            
            if (in_array('admin', $roles)) {
                $this->redirect(':Admin:Dashboard:default');
            } elseif (in_array('editor', $roles)) {
                $this->redirect(':Admin:Editor:default');
            } else {
                $this->redirect('User:profile');
            }
        }
        
        // For non-logged-in users, the default template will be rendered
    }
    
    /**
     * Renders the login form
     * 
     * This is the default view method that displays the login page.
     * The template displays the login form and any error messages.
     * 
     * @return void
     */
    public function renderDefault(): void
    {
        // Set template variables if needed
        $this->template->pageTitle = 'Přihlášení';
        $this->template->metaDescription = 'Přihlášení do uživatelského účtu';
    }
}