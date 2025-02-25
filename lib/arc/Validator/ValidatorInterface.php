<?php declare(strict_types=1);

namespace Arc\Validator;

interface ValidatorInterface
{
    public function validate(mixed $value, array $options = []): true | array;
}
