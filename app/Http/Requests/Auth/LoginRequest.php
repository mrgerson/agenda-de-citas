<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'login' => [
                'required',
                'string',
                'max:255',
            ],
            'password' => [
                'required',
                'string',
                'min:6',
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'login.required' => 'El campo usuario/email es obligatorio.',
            'login.string' => 'El campo usuario/email debe ser texto.',
            'login.max' => 'El campo usuario/email no puede tener más de 255 caracteres.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.string' => 'La contraseña debe ser texto.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'login' => 'usuario/email',
            'password' => 'contraseña',
        ];
    }
}
