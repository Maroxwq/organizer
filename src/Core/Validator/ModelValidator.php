<?php declare(strict_types=1);

namespace Org\Core\Validator;

class ModelValidator
{
    public function validate($model)
    {
        $rules = $model->validationRules();
        $errors = [];

    //     foreach ($rules as $fieldRule) {
    //         foreach ($fieldRule as $field => $rule) {
    //             $getterName 
    //         }
    //     }

        foreach ($rules as $rule) {
            foreach ($rule as $field => $validations) {
                $value = null;
                if ($field === 'content') {
                    $value = $model->getContent();
                } elseif ($field === 'color') {
                    $value = $model->getColor();
                }
                foreach ($validations as $validation => $params) {
                    if ($validation === 'required' && $params === true && empty($value)) {
                        $errors[$field][] = "Поле контент не может быть пустым";
                    }

                    if ($validation === 'string' && isset($params['maxLength'])) {
                        if (!is_string($value)) {
                            $errors[$field][] = "Поле контент должно быть строкой";
                        } elseif (strlen($value) > $params['maxLength']) {
                            $errors[$field][] = "Поле контент не может быть длинне 255 символов";
                        }
                    }
                }
            }
        }
    
        return $errors;
    }
    
}
