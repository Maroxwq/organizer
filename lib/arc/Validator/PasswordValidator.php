<?php declare(strict_types=1);

namespace Arc\Validator;

class PasswordValidator implements ValidatorInterface
{
    public function validate(mixed $value, array $options = []): true|array
    {
        $errors = [];

        if (!is_string($value)) {
            return ["Password must be a string."];
        }
        if (empty($value)) {
            $errors[] = "Password is required.";
        }
        $minLength = $options['minLength'] ?? 6;
        if (strlen($value) < $minLength) {
            $errors[] = "Password must be at least {$minLength} characters.";
        }
        if (isset($options['maxLength']) && strlen($value) > $options['maxLength']) {
            $errors[] = "Password must be at most {$options['maxLength']} characters.";
        }

        return empty($errors) ? true : $errors;
    }
}
