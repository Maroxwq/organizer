<?php declare(strict_types=1);

namespace Arc\Db;

class ModelDefinition
{
    public function __construct(private string $modelClass) {}

    public function getRepositoryClass(): string
    {
        return str_replace('\\Model\\', '\\Repository\\', $this->modelClass) . 'Repository';
    }

    public function getModelClass(): string
    {
        return $this->modelClass;
    }

    public function tableName(): string
    {
        return $this->modelClass::tableName();
    }

    public function attributes(): array
    {
        return $this->modelClass::attributes();
    }
}
