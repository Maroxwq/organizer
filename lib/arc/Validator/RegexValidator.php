<?php declare(strict_types=1);

namespace Arc\Validator;

class RegexValidator implements ValidatorInterface
{
    public function validate(mixed $value, array $options = []): true|array
    {
        if (!isset($options['pattern']) || !is_string($options['pattern'])) {
            return ['Invalid value'];
        }

        return preg_match($options['pattern'], $value) ? true : ['Invalid value'];
    }
}
