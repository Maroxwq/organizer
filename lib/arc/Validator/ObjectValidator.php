<?php declare(strict_types=1);

namespace Arc\Validator;

class ObjectValidator
{
    public function __construct(private ValidatorFactory $factory) {}

    public function validate(ValidatableInterface $obj): array
    {
        $errors = [];
        $factory = new ValidatorFactory();
        foreach ($obj->validationRules() as $ruleSet) {
            foreach ($ruleSet as $field => $validations) {
                $getter = 'get' . ucfirst($field);
                if (!method_exists($obj, $getter)) {
                    throw new \RuntimeException("Getter {$getter} not found");
                }
                $value = $obj->$getter();
                foreach ($validations as $type => $options) {
                    $validator = $factory->create($type);
                    $result = $validator->validate($value, is_array($options) ? $options : []);
                    if ($result !== true) {
                        $obj->addError($field, array_shift($result));
                    }
                }
            }
        }

        return $errors;
    }
}
