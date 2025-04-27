<?php declare(strict_types=1);

namespace Arc\Validator;

use Arc\Db\Model;

class ChainValidator
{
    public function validate(Model $model): array
    {
        $errors = [];
        $factory = new ValidatorFactory();
        foreach ($model->validationRules() as $ruleSet) {
            foreach ($ruleSet as $field => $validations) {
                $getter = 'get' . ucfirst($field);
                if (!method_exists($model, $getter)) {
                    throw new \RuntimeException("Getter {$getter} not found");
                }
                $value = $model->$getter();

                foreach ($validations as $type => $options) {
                    $validator = $factory->create($type);
                    $opts = is_array($options) ? $options : [];
                    $result = $validator->validate($value, $opts);
                    if ($result !== true) {
                        $errors[$field] = is_array($result) ? implode(' ', $result) : $result;
                    }
                }
            }
        }

        return $errors;
    }
}
