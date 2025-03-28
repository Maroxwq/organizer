<?php declare(strict_types=1);

namespace Arc\Db;

abstract class Model
{
    private ?int $id = null;

    abstract public static function tableName(): string;
    abstract public static function attributes(): array;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function isNew(): bool
    {
        return $this->id === null;
    }

    public function load(array $data): bool
    {
        foreach (static::attributes() as $attr) {
            if (isset($data[$attr])) {
                $setter = 'set' . ucfirst($attr);
                if (method_exists($this, $setter)) {
                    $this->$setter($data[$attr]);
                } else {
                    $this->$attr = $data[$attr];
                }
            }
        }

        return true;
    }

    public function asArray(): array
    {
        $data = [];
        foreach (static::attributes() as $attr) {
            $getter = 'get' . ucfirst($attr);
            if (method_exists($this, $getter)) {
                $data[$attr] = $this->$getter();
            } else {
                $data[$attr] = $this->$attr;
            }
        }

        return $data;
    }

    public static function fromArray(array $data): static
    {
        $model = new static();
        $model->load($data);
        if (isset($data['id'])) {
            $model->setId((int) $data['id']);
        }

        return $model;
    }
}
