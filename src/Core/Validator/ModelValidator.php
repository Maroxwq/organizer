<?php declare(strict_types=1);

namespace Org\Core\Validator;

class ModelValidator
{
    public function validate($model)
    {
        $rules = $model->validationRules();
    }
}
