<?php

namespace App\Http\Validators;

use Illuminate\Validation\Validator;

class HelloValidator extends Validator
{
    public function validateHello($attribute, $value, $paramaters)
    {
        return $value % 2 == 0;
    }
}
