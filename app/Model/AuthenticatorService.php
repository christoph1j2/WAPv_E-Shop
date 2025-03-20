<?php

declare(strict_types=1);

namespace App\Model;

use Nette;
use Nette\Security\Authenticator;
use Nette\Security\SimpleIdentity;
use Nette\Security\Passwords;
use Nette\Database\Explorer;

class AuthenticatorService implements Authenticator
{
    private $database;
    private $passwords;

    public function __construct(Explorer $database, Passwords $passwords)
    {
        $this->database = $database;
        $this->passwords = $passwords;
    }

    public function authenticate(string $username, string $password): SimpleIdentity
    {
        $row = $this->database->table('users')
            ->where('username', $username)
            ->fetch();

        if (!$row) {
            throw new Nette\Security\AuthenticationException('Uživatel nenalezen.');
        }

        if (!$this->passwords->verify($password, $row->password)) {
            throw new Nette\Security\AuthenticationException('Nesprávné heslo.');
        }

        return new SimpleIdentity(
            $row->id,
            $row->role, // role
            [
                'username' => $row->username,
                'email' => $row->email,
            ]
        );
    }
}
