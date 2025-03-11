<?php declare(strict_types=1);

namespace Arc\Db;

abstract class Model
{
    abstract public static function tableName(): string;
    abstract public static function attributes(): array;
    abstract public function getId(): ?int;
    abstract public function setId(int $id): void;
}
