<?php declare(strict_types=1);

namespace Arc\Validator;

class StringValidator implements ValidatorInterface
{
    public function validate(mixed $value, array $options = []): true | array
    {
        if (!is_string($value)) {
            return [$value . 'field must be a string'];
        }
        if (isset($options['maxLength']) && strlen($value) > $options['maxLength']) {
            return ['Maximum length: ' . $options['maxLength']];
        }
        if (isset($options['minLength']) && strlen($value) < $options['minLength']) {
            return ['Minimum length: ' . $options['minLength']];
        }
        
        return true;
    }
}
