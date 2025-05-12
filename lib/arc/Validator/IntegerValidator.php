<?php declare(strict_types=1);

namespace Arc\Validator;

class IntegerValidator implements ValidatorInterface
{
    public function validate(mixed $value, array $options = []): true|array
    {
        if (!is_int($value)) {
            return ['Must be an integer'];
        }
        if (isset($options['min']) && $value < $options['min']) {
            return ["Must be at least {$options['min']}"];
        }
        if (isset($options['max']) && $value > $options['max']) {
            return ["Must be at most {$options['max']}"];
        }

        return true;
    }
}
