<?php

declare(strict_types=1);

namespace App\Presentation\Accessory\Repository;

use App\Presentation\Accessory\Base\BaseRepository;
use Nette\Database\Table\Selection;

class CategoryRepository extends BaseRepository
{
    protected string $tableName = 'categories';

    public function findByName(string $name): ?Selection
    {
        return $this->database->table($this->tableName)->where('name', $name);
    }

    public function getAll(): Selection
    {
        return $this->database->table($this->tableName);
    }
}
