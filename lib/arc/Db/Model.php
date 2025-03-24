<?php declare(strict_types=1);

namespace Arc\Db;

abstract class Model
{
    protected ?int $id = null;

    abstract public static function tableName(): string;
    abstract public static function attributes(): array;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function isNew(): bool
    {
        return $this->id === null;
    }

    public function load(array $data): bool
    {
        foreach (static::attributes() as $attr) {
            if (isset($data[$attr])) {
                $this->$attr = $data[$attr];
            }
        }

        return true;
    }

    public static function staticCreateFromArray(array $data): static
    {
        $model = new static();
        $model->load($data);
        if (isset($data['id'])) {
            $model->setId((int)$data['id']);
        }

        return $model;
    }
}
