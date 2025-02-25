<?php declare(strict_types=1);

namespace Arc\Validator;

class RequiredValidator implements ValidatorInterface
{
    public function validate(mixed $value, array $options = []): true | array
    {
        if (empty($value)) {
            $errors = ['Поле не должно быть пустым'];
        }

        return $errors ?? true;
    }
}