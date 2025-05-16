<?php declare(strict_types=1);

namespace Arc\Validator;

class PasswordValidator implements ValidatorInterface
{
    public function validate(mixed $value, array $options = []): true|array
    {
        $errors = [];
        if (($minUpper = $options['minUpper'] ?? 0) > 0 && preg_match_all('/[A-Z]/', $value) < $minUpper) {
            $errors[] = "Must contain at least {$minUpper} uppercase letters";
        }
        if (($minDigits = $options['minDigits'] ?? 0) > 0 && preg_match_all('/\d/', $value) < $minDigits) {
            $errors[] = "Must contain at least {$minDigits} digit(s)";
        }

        return $errors ? $errors : true;
    }
}
