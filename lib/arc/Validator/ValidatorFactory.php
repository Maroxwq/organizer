<?php declare(strict_types=1);

namespace Arc\Validator;

use Arc\Validator\ValidatorInterface;

class ValidatorFactory
{
    public function create(string $validatorName): ValidatorInterface
    {
        $class = '\\Arc\\Validator\\' . ucfirst($validatorName) . 'Validator';

        if (!class_exists($class)) {
            throw new \RuntimeException('Class does not exist ' . $class);
        }

        return new $class();
    }
}
