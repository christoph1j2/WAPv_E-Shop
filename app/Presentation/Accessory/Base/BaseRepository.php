<?php

declare(strict_types=1);

namespace App\Presentation\Accessory\Base;

use App\Presentation\Accessory\Base\BaseModel;
use Nette\Database\Table\ActiveRow;
use Nette\Database\Table\Selection;

abstract class BaseRepository extends BaseModel
{
    protected string $tableName;

    // public function getAll(): Selection
    // {
    //     return $this->database->table($this->tableName);
    // }

    public function getById(int $id): ?ActiveRow
    {
        return $this->database->table($this->tableName)->get($id);
    }

    public function insert(array $data): ActiveRow
    {
        return $this->database->table($this->tableName)->insert($data);
    }

    public function update(int $id, array $data): bool
    {
        $row = $this->getById($id);
        return $row ? $row->update($data) : false;
    }

    public function delete(int $id): bool
    {
        $row = $this->getById($id);
        return $row ? (bool) $row->delete() : false;
    }
}
