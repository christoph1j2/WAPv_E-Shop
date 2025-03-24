<?php

declare(strict_types=1);

namespace App\Presentation\Accessory\Repository;

use App\Presentation\Accessory\Base\BaseRepository;
use Nette\Database\Table\ActiveRow;
use Nette\Database\Table\Selection;

class UserRepository extends BaseRepository
{
    protected string $tableName = 'users';

    public function findByEmail(string $email): ?ActiveRow
    {
        return $this->database->table($this->tableName)->where('email', $email)->fetch();
    }

    public function findAdmins(): Selection
    {
        return $this->database->table($this->tableName)->where('is_admin', true);
    }

    public function findUsers(): Selection
    {
        return $this->database->table($this->tableName)->where('is_admin', false);
    }

    public function findById(int $id): ?ActiveRow
    {
        return $this->database->table($this->tableName)->get($id);
    }

    public function findOrders(int $userId): Selection
    {
        return $this->database->table('orders')->where('user_id', $userId);
    }

    public function getTotalCount(): int
    {
        return $this->database->table($this->tableName)->count('*');
    }

    public function getAll(): Selection
    {
        return $this->database->table($this->tableName);
    }
}
