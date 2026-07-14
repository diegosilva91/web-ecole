<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseURLRequest extends FormRequest
{
    public function rules()
    {
        return [
            'category' => [
                'required'
            ]
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge(['category' => $this->route('category')]);
    }
}
