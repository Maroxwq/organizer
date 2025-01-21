<?php declare(strict_types=1);

namespace Org\Core\Validator;

interface ValidatorInterface
{
    public function validate(mixed $value, array $options = []): true | array;
}
