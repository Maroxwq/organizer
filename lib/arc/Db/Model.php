<?php declare(strict_types=1);

namespace Arc\Db;

abstract class Model
{
    protected ?int $id = null;

    abstract public static function tableName(): string;
    abstract public static function attributes(): array;
    abstract public function fromDbRow(array $dbRow): void;

    public function getId(): ?int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }
}
