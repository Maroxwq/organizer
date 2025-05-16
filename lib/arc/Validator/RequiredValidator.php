<?php declare(strict_types=1);

namespace Arc\Validator;

class RequiredValidator implements ValidatorInterface
{
    public function validate(mixed $value, array $options = []): true|array
    {
        if (isset($options['required']) && !$options['required']) {
            return true;
        }

        $message = $options['message'] ?? 'This field is required';

        if (empty($value)) {
            return [$message];
        }

        return true;
    }
}
