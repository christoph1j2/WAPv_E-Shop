<?php

declare(strict_types=1);

namespace App\Presentation\Accessory\Repository;

use App\Presentation\Accessory\Base\BaseRepository;
use App\Presentation\Accessory\Model\Product;
use Nette\Database\Table\Selection;

class ProductRepository extends BaseRepository
{
    protected string $tableName = 'products';

    public function findByCategory(int $categoryId): Selection
    {
        return $this->database->table($this->tableName)
            ->where('category_id', $categoryId);
    }

    public function findInStock(): Selection
    {
        return $this->database->table($this->tableName)
            ->where('stock_quantity > ?', 0);
    }

    public function getTotalCount(): int
    {
        return $this->database->table($this->tableName)->count('*');
    }

    public function getLowStock(int $limit): Selection
    {
        return $this->database->table($this->tableName)
            ->where('stock_quantity < ?', 5)
            ->limit($limit);
    }

    public function getRecent(int $limit): Selection
    {
        return $this->database->table($this->tableName)
            ->order('created_at DESC')
            ->limit($limit);
    }

    public function getAll(): Selection
    {
        return $this->database->table($this->tableName);
    }
}
