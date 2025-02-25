<?php declare(strict_types=1);

namespace Arc\Validator;

class StringValidator implements ValidatorInterface
{
    public function validate(mixed $value, array $options = []): true | array
    {
        if (!is_string($value)) {
            return ['Поле должно быть строкой'];
        }
        if (isset($options['maxLength']) && strlen($value) > $options['maxLength']) {
            return ['Максимальная длина: ' . $options['maxLength']];
        }
        
        return true;
    }
}
