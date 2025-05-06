<?php declare(strict_types=1);

namespace Arc\Validator;

class IntegerValidator implements ValidatorInterface
{
    public function validate(mixed $value, array $options = []): true | array
    {
        if (!is_int($value)) {
            return ['Must be an integer'];
        }

        return true;
    }
}
