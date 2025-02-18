<?php declare(strict_types=1);

namespace Org\Core\Validator;

class RegexValidator implements ValidatorInterface
{
    public function validate(mixed $value, array $options = []): true | array
    {
        if (!isset($options['pattern']) || !is_string($options['pattern'])) {
            return ['Цвет указан неправильно'];
        }

        return preg_match($options['pattern'], $value) ? true : ['Неправильно указан цвет'];
    }
}
