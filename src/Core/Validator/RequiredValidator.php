<?php declare(strict_types=1);

namespace Org\Core\Validator;

class RequiredValidator implements ValidatorInterface
{
    public function validate(mixed $value, array $options = []): true | array
    {
        if (empty($value)) {
            $errors = ['Value is required'];
        }

        return $errors ?? true;
    }
}