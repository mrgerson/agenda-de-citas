<?php

namespace App\Http\Requests\Admision;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdmisionRequest extends FormRequest
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
            'cita_id' => [
                'required',
                'integer',
                'exists:citas,id',
            ],
            'asistencia' => [
                'boolean',
            ],
            'notas' => [
                'nullable',
                'string',
                'max:1000',
            ],
            'estado' => [
                'sometimes',
                'string',
                Rule::in(['pendiente', 'admitido', 'no_asistio']),
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'cita_id.required' => 'La cita es obligatoria.',
            'cita_id.exists' => 'La cita seleccionada no existe.',

            'asistencia.boolean' => 'El campo asistencia debe ser verdadero o falso.',

            'notas.string' => 'Las notas deben ser texto.',
            'notas.max' => 'Las notas no pueden tener más de 1000 caracteres.',

            'estado.in' => 'El estado seleccionado no es válido.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'cita_id' => 'cita',
            'asistencia' => 'asistencia',
            'notas' => 'notas',
            'estado' => 'estado',
        ];
    }
}
