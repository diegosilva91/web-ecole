<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class RegisterRequest extends FormRequest
{
    public static $rules = [
        'name' => [ 'required', 'string', 'max:255' ],
        'email' => [ 'required', 'string', 'email', 'max:255', 'unique:users' ],
        'password' => [ 'required', 'string', 'min:8' ], //'confirmed'
        'phone' => [ 'required', 'regex:/(\+34|0034|34)?[ -]*(6|7)[ -]*([0-9][ -]*){8}/' ],
        'terms' => [ 'required',  'in:1' ]
    ];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return self::$rules;
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     * @return void
     *
     * @throws ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $response = [
            "success" => false, // Here I added a new field on JSON response.
            "message" => __("Los datos enviados no son válidos."), // Here I used a custom message.
            "errors" => $validator->errors(), // And do not forget to add the common errors.
        ];

        if ($this->expectsJson()) {
            throw new HttpResponseException(response()->json($response, 422));
        }
        throw (new ValidationException($validator, $response))
            ->errorBag($this->errorBag)//->redirectTo($this->getRedirectUrl())
        ;
        // Finally throw the HttpResponseException.
    }
}
