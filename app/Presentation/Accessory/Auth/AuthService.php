<?php
/**
 * AuthService.php
 * 
 * This file contains the AuthService class which handles all authentication-related
 * functionality for the application, including user registration, login, and
 * password management.
 * 
 * @package App\Presentation\Auth
 * @version 1.0
 */

declare(strict_types=1);

namespace App\Presentation\Auth;

use Nette\Database\Explorer;
use Nette\Security\Passwords;
use Nette\Security\AuthenticationException;

/**
 * AuthService Class
 * 
 * Provides comprehensive authentication services for the application including:
 * - User registration
 * - User login authentication
 * - Password management (changing and resetting)
 * - Security token handling for password resets
 * 
 * This service interacts with the database to verify credentials and manage user accounts.
 */
final class AuthService
{
    /**
     * Authentication error constants
     * 
     * These constants define error codes returned during authentication failures
     */
    public const IDENTITY_NOT_FOUND = 1;  // User account was not found in the database
    public const INVALID_CREDENTIAL = 2;  // Password provided does not match stored password

    /**
     * @var Explorer $database Database connection instance for user operations
     */
    private Explorer $database;
    
    /**
     * @var Passwords $passwords Password hashing and verification service
     */
    private Passwords $passwords;

    /**
     * Constructor initializes the authentication service with required dependencies
     * 
     * @param Explorer $database  Database connection for user data access
     * @param Passwords $passwords Password hashing and verification service
     */
    public function __construct(Explorer $database, Passwords $passwords)
    {
        $this->database = $database;
        $this->passwords = $passwords;
    }

    /**
     * Registers a new user in the system
     * 
     * Creates a new user account with the provided information. Performs validation
     * to ensure the email is not already registered, then securely hashes the password
     * before storing the user data.
     * 
     * @param string $name     User's full name
     * @param string $email    User's email address (used as username)
     * @param string $password User's plain text password (will be hashed)
     * 
     * @throws \Exception If the email is already registered in the system
     * @return void
     */
    public function register(string $name, string $email, string $password): void
    {
        // Check if email already exists
        $users = $this->database->table('users');
        if ($users->where('email', $email)->fetch()) {
            throw new \Exception('Tento e-mail je již registrován.');
        }

        // Hash the password and insert new user
        $hashedPassword = $this->passwords->hash($password);
        $users->insert([
            'name'       => $name,
            'email'      => $email,
            'password_hash'   => $hashedPassword,
            'created_at' => (new \DateTime())->format('Y-m-d H:i:s'),
        ]);
    }

/**
     * Authenticates a user based on email and password
     * 
     * Validates the provided credentials against the database and returns user data
     * if authentication is successful. The method performs several checks:
     * 1. Verifies the user exists in the database
     * 2. Validates the password matches the stored hash
     * 3. Confirms the user account is active
     * 
     * @param string $email    User's email address
     * @param string $password User's password to verify
     * 
     * @throws AuthenticationException When authentication fails with user-friendly error messages
     *        that can be directly displayed in forms or flash messages
     * @return array User data as an array if authentication is successful
     */
    public function login(string $email, string $password): array
    {
        // Validate email format before database query
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new AuthenticationException('Zadejte platnou e-mailovou adresu.', self::INVALID_CREDENTIAL);
        }
        
        // Retrieve user by email
        $user = $this->database->table('users')->where('email', $email)->fetch();
        
        // Check if user exists with form-friendly message
        if (!$user) {
            throw new AuthenticationException('Účet s touto e-mailovou adresou nebyl nalezen.', self::IDENTITY_NOT_FOUND);
        }
        
        // Verify password against stored hash with form-friendly message
        if (!$this->passwords->verify($password, $user->password_hash)) {
            throw new AuthenticationException('Nesprávné heslo. Zkuste to prosím znovu.', self::INVALID_CREDENTIAL);
        }
        
        // Check if account is active with detailed message
        if (!$user->active) {
            throw new AuthenticationException('Váš účet není aktivní. Kontaktujte prosím podporu pro více informací.');
        }
        
        // Check for too many failed login attempts (if tracking is implemented)
        if (isset($user->failed_attempts) && $user->failed_attempts >= 5) {
            throw new AuthenticationException('Účet byl dočasně uzamčen z bezpečnostních důvodů. Zkuste to prosím později nebo obnovte heslo.');
        }
        
        // Reset failed login attempts if any (would require additional field)
        if (isset($user->failed_attempts) && $user->failed_attempts > 0) {
            $this->database->table('users')->where('id', $user->id)->update([
                'failed_attempts' => 0
            ]);
        }
        
        // Return user data for creating identity
        return $user->toArray();
    }

    /**
     * Changes a user's password after verifying their current password
     * 
     * This method implements a secure password change process:
     * 1. Verifies the user exists
     * 2. Validates the current password is correct
     * 3. Hashes the new password
     * 4. Updates the password in the database
     * 
     * @param int $userId          ID of the user changing their password
     * @param string $currentPassword The user's current password for verification
     * @param string $newPassword     The new password to set
     * 
     * @throws \Exception If the user is not found or current password is incorrect
     * @return void
     */
    public function changePassword(int $userId, string $currentPassword, string $newPassword): void
    {
        // Load user from database
        $user = $this->database->table('users')->get($userId);
        
        // Verify user exists
        if (!$user) {
            throw new \Exception('Uživatel nenalezen.');
        }
        
        // Verify current password is correct
        if (!$this->passwords->verify($currentPassword, $user->password_hash)) {
            throw new \Exception('Aktuální heslo není správné.');
        }
        
        // Hash the new password
        $hashedPassword = $this->passwords->hash($newPassword);
        
        // Update password in database
        $this->database->table('users')->where('id', $userId)->update([
            'password_hash' => $hashedPassword
        ]);
    }

    /**
     * Generates a password reset token and stores it in the database
     * 
     * Creates a secure, time-limited token for password reset process:
     * 1. Verifies the user exists by email
     * 2. Generates a cryptographically secure random token
     * 3. Sets an expiration time (1 hour from generation)
     * 4. Stores the token in the database linked to the user
     * 
     * @param string $email Email address of the user requesting password reset
     * 
     * @return string|false The generated token or false if user not found
     */
    public function requestPasswordReset(string $email)
    {
        // Find user by email
        $user = $this->database->table('users')->where('email', $email)->fetch();
        if (!$user) {
            return false;
        }
        
        // Generate cryptographically secure random token
        $token = bin2hex(random_bytes(16));
        $expires = (new \DateTime())->modify('+1 hour')->format('Y-m-d H:i:s');
        
        // Store token with expiration in database
        $this->database->table('password_resets')->insert([
            'user_id' => $user->id,
            'token' => $token,
            'expires_at' => $expires,
        ]);
        
        return $token;
    }

    /**
     * Verifies a reset token and sets a new password if valid
     * 
     * Completes the password reset process:
     * 1. Validates the token exists and has not expired
     * 2. Hashes the new password
     * 3. Updates the user's password in the database
     * 4. Removes the used token to prevent reuse
     * 
     * @param string $token       The password reset token to verify
     * @param string $newPassword The new password to set if token is valid
     * 
     * @return bool True if password was reset successfully, false otherwise
     */
    public function resetPassword(string $token, string $newPassword): bool
    {
        // Find valid token that hasn't expired
        $reset = $this->database->table('password_resets')
            ->where('token', $token)
            ->where('expires_at > ?', new \DateTime())
            ->fetch();
            
        // Return false if token invalid or expired
        if (!$reset) {
            return false;
        }
        
        // Hash the new password securely
        $hashedPassword = $this->passwords->hash($newPassword);
        
        // Update user's password
        $this->database->table('users')
            ->where('id', $reset->user_id)
            ->update(['password_hash' => $hashedPassword]);
        
        // Remove the used token for security
        $this->database->table('password_resets')->where('id', $reset->id)->delete();
        
        return true;
    }
}