<?php declare(strict_types=1);

namespace Arc\Validator;

class EmailValidator implements ValidatorInterface
{
    public function validate(mixed $value, array $options = []): true | array
    {
        $errors = [];

        $strV = new StringValidator();
        $regV = new RegexValidator();

        $strRes = $strV->validate($value, ['maxLength' => 20]);
        if ($strRes !== true) {
            $errors[] = $strRes;
        }

        $regex = '/.+@.+/';
        $regRes = $regV->validate($value, ['pattern' => $regex]);
        if ($regRes !== true) {
            $errors[] = $regRes;
        }

        if (!empty($errors)) {
            return $errors;
        } else {
            return true;
        }
    }
}