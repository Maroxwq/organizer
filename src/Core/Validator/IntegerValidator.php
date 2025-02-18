<?php declare(strict_types=1);

namespace Org\Core\Validator;

class IntegerValidator implements ValidatorInterface
{
    public function validate(mixed $value, array $options = []): true | array
    {
        if (!is_int($value)) {
            return ['Значение должно быть числовым'];
        }

        return true;
    }
}
