<?php declare(strict_types=1);

namespace Arc\Validator;

class RequiredValidator implements ValidatorInterface
{
    public function validate(mixed $value, array $options = []): true | array
    {
        if (empty($value)) {
            $errors = ['This field is required'];
        }

        return $errors ?? true;
    }
}
