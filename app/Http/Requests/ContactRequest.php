<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $valid = [
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'number' => 'required',
            'category' => 'required',
            'message' => 'required',
//            'sender' => 'required'
        ];
        if (parse_url($this->header('referer'), PHP_URL_PATH) === '/es') {
            unset($valid['subject']);
            unset($valid['category']);
            return $valid;
        } else {
            if (!empty($this->input('number') && !empty($this->input('email')))) {
                unset($valid['message']);
            }
            if ($this->input('subject') === 'Solicitud de Sesión Online Informativa') {
                return $valid;
            } else {
                unset($valid['category']);
                return $valid;
            }
        }
    }

    public function prepareForValidation()
    {
        if (parse_url($this->header('referer'), PHP_URL_PATH) === '/es' && $this->has('subject') === false) {
            $this->merge(['subject' => 'home']);
        }
    }

    public function messages()
    {
        return [
            'name.required' => 'Nombre es requerido',
            'email.required' => 'Correo electrónico es requerido',
            'email.email' => 'El email debe ser válido',
            'subject.required' => 'Debe definir el asunto',
            'number.required' => 'Debe definir el teléfono',
            'category.required' => 'Debe definir la categoría',
            'message.required' => 'Mensaje es requerido',
        ];
    }
}
