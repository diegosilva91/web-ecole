<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PromoCodeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'course_id' => 'integer',
            'type_coupon' => 'required|integer|min:0|max:100',
        ];
    }
    protected function prepareForValidation()
    {
    }
}
