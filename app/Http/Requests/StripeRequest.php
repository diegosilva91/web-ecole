<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StripeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'id' => 'required|string|max:255',
            'data.object.id' => 'required|string|max:255',
            'data.object.object' => 'required|string|max:255',
            'data.object.billing_cycle_anchor' => 'required|integer',
            'data.object.status' => 'required|string|max:255',
            'data.object.customer' => 'required|string|max:255',
            'data.object.metadata' => 'present|array',
            'type' => 'required|string|max:255',
        ];
    }
}
