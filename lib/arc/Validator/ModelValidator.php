<?php declare(strict_types=1);

namespace Arc\Validator;

use Arc\Validator\ValidatorFactory;

class ModelValidator
{
    public function validate($model): array
    {
        $rules = $model->validationRules();
        $factory = new ValidatorFactory();
        $errors = [];

        foreach ($rules as $ruleList) {
            foreach ($ruleList as $field => $validations) {
                $getter = 'get' . ucfirst($field);

                if (!method_exists($model, $getter)) {
                    throw new \RuntimeException('Method does not exist ' . $getter);
                }

                $value = $model->$getter();

                foreach ($validations as $type => $options) {
                    $validator = $factory->create($type);

                    if (!is_array($options)) {
                        $options = [];
                    }

                    $result = $validator->validate($value, $options);

                    if ($result !== true) {
                        $errors[$field] = array_merge($errors[$field] ?? [], (array)$result);
                    }
                }
            }
        }

        return $errors;
    }
}
