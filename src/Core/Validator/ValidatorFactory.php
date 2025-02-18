<?php declare(strict_types=1);

namespace Org\Core\Validator;

use Org\Core\Validator\ValidatorInterface;

class ValidatorFactory
{
    public function create(string $validatorName): ValidatorInterface
    {
        $class = '\\Org\\Core\\Validator\\' . ucfirst($validatorName) . 'Validator';

        if (!class_exists($class)) {
            throw new \RuntimeException('Class does not exist ' . $class);
        }

        return new $class();
    }
}
