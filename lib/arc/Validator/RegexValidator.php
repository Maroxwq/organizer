<?php declare(strict_types=1);

namespace Arc\Validator;

class RegexValidator implements ValidatorInterface
{
    public function validate(mixed $value, array $options = []): true|array
    {
        if (!isset($options['pattern']) || !is_string($options['pattern'])) {
            return ['Value does not match the regex pattern'];
        }

        return preg_match($options['pattern'], $value) ? true : ['Value does not match the regex pattern'];
    }
}
