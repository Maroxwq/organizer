<?php declare(strict_types=1);

namespace Arc\Db;

use Arc\Validator\ObjectValidator;
use Arc\Validator\ValidatableInterface;
use Arc\Validator\ValidatorFactory;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

abstract class Model implements ValidatableInterface
{
    private ?int $id = null;
    private array $errors = [];
    protected PropertyAccessorInterface $pa;

    abstract public static function tableName(): string;
    abstract public static function attributes(): array;
    abstract public function validationRules(): array;

    public function __construct()
    {
        $this->pa = PropertyAccess::createPropertyAccessorBuilder()
            ->enableExceptionOnInvalidIndex()
            ->getPropertyAccessor();
    }

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

    public function publicAttributes(): array
    {
        $attributes = [];
        foreach ($this->validationRules() as $rule) {
            $attributes = array_merge($attributes, array_keys($rule));
        }

        return array_unique($attributes);
    }

    public function load(array $data): bool
    {
        $isSet = false;
        foreach ($this->publicAttributes() as $attr) {
            if (array_key_exists($attr, $data)) {
                $this->pa->setValue($this, $attr, $data[$attr]);
                $isSet = true;
            }
        }

        return $isSet;
    }

    public function asArray(): array
    {
        $data = [];
        foreach (static::attributes() as $attr) {
            $data[$attr] = $this->pa->getValue($this, $attr);
        }

        return $data;
    }

    public function isValid(): bool
    {
        $validator = new ObjectValidator(new ValidatorFactory());
        $validator->validate($this);

        return !$this->hasErrors();
    }

    public function getError(string $field): string|null
    {
        return $this->errors[$field] ?? null;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    public function addError(string $field, string $message): static
    {
        $this->errors[$field] = $message;

        return $this;
    }

    public static function fromArray(array $data): static
    {
        $model = new static();
        foreach (static::attributes() as $attr) {
            if (array_key_exists($attr, $data)) {
                $model->pa->setValue($model, $attr, $data[$attr]);
            }
        }
        if (isset($data['id'])) {
            $model->setId((int) $data['id']);
        }

        return $model;
    }
}
