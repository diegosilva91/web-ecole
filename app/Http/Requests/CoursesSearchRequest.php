<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CoursesSearchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'areas' => 'string',
            'categories' => 'string',
            'type_course' => 'string',
            'specializations' => 'string',
            'tag' => 'array',
            'search' => 'string',
            'age' => 'array'
        ];
    }

    protected function prepareForValidation()
    {
    }
}
