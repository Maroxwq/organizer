<?php declare(strict_types=1);

namespace Arc\Validator;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

class ObjectValidator implements ValidatorInterface
{
    private PropertyAccessorInterface $pa;

    public function __construct(private ValidatorFactory $factory)
    {
        $this->pa = PropertyAccess::createPropertyAccessor();
    }

    public function validate(mixed $obj, array $options = []): array
    {
        $errors = [];
        foreach ($obj->validationRules() as $ruleSet) {
            foreach ($ruleSet as $field => $validations) {
                if (!$this->pa->isReadable($obj, $field)) {
                    throw new \RuntimeException("Property {$field} is not readable");
                }
                $value = $this->pa->getValue($obj, $field);
                foreach ($validations as $type => $options) {
                    $validator = $this->factory->create($type);
                    $result = $validator->validate($value, is_array($options) ? $options : [$options]);
                    if ($result !== true) {
                        $obj->addError($field, array_shift($result));
                    }
                }
            }
        }

        return $errors;
    }
}
