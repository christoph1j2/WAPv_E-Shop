<?php

declare(strict_types=1);

namespace App\Presentation\Accessory\Repository;

use App\Presentation\Accessory\Base\BaseRepository;
use Nette\Database\Table\Selection;

class OrderRepository extends BaseRepository
{
    protected string $tableName = 'orders';

    public function findByUserId(int $userId): Selection
    {
        return $this->database->table($this->tableName)
            ->where('user_id', $userId);
    }

    public function findByStatus(string $status): Selection
    {
        return $this->database->table($this->tableName)
            ->where('status', $status);
    }

    public function getTotalCount(): int
    {
        return $this->database->table($this->tableName)->count('*');
    }

    public function getRecent(int $limit): Selection
    {
        return $this->database->table($this->tableName)
            ->order('created_at DESC')
            ->limit($limit);
    }

    public function getOrderItems(int $orderId): Selection
    {
        return $this->database->table('order_items')
            ->where('order_id', $orderId);
    }

    public function addOrderItem(array $data): void
    {
        $this->database->table('order_items')->insert($data);
    }

    public function getOrdersByUser(int $userId): Selection
    {
        return $this->database->table($this->tableName)
            ->where('user_id', $userId)
            ->order('created_at DESC');
    }

        /**
     * Vrátí všechny objednávky seřazené od nejnovější
     */
    public function getAll()
    {
        return $this->database->table('orders')
            ->order('created_at DESC')
            ->fetchAll();
    }
}
