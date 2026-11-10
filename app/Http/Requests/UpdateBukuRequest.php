<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateBukuRequest extends StoreBukuRequest
{
    public function rules(): array
    {
        $rules = parent::rules();

        foreach ($rules as $field => $rule) {
            $rules[$field] = array_merge(['sometimes'], array_diff($rule, ['required']));
        }

        return $rules;
    }
}

