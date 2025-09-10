<?php

namespace App\Http\Requests\Paciente;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PacienteRequest extends FormRequest
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
        $pacienteId = $this->getPacienteId();

        return [
            'nombre' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/',
            ],
            'documento' => [
                'required',
                'string',
                'max:20',
                'regex:/^[0-9]+$/',
                Rule::unique('pacientes', 'documento')->ignore($pacienteId),
            ],
            'fecha_nacimiento' => [
                'required',
                'date',
                'before:today',
                'after:1900-01-01',
            ],
            'telefono' => [
                'required',
                'string',
                'max:15',
                'regex:/^[0-9\-\+\s\(\)]+$/',
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.string' => 'El nombre debe ser texto.',
            'nombre.max' => 'El nombre no puede tener más de 255 caracteres.',
            'nombre.regex' => 'El nombre solo puede contener letras y espacios.',

            'documento.required' => 'El documento es obligatorio.',
            'documento.string' => 'El documento debe ser texto.',
            'documento.max' => 'El documento no puede tener más de 20 caracteres.',
            'documento.regex' => 'El documento solo puede contener números.',
            'documento.unique' => 'Ya existe un paciente con este documento.',

            'fecha_nacimiento.required' => 'La fecha de nacimiento es obligatoria.',
            'fecha_nacimiento.date' => 'La fecha de nacimiento debe ser una fecha válida.',
            'fecha_nacimiento.before' => 'La fecha de nacimiento debe ser anterior a hoy.',
            'fecha_nacimiento.after' => 'La fecha de nacimiento debe ser posterior a 1900.',

            'telefono.required' => 'El teléfono es obligatorio.',
            'telefono.string' => 'El teléfono debe ser texto.',
            'telefono.max' => 'El teléfono no puede tener más de 15 caracteres.',
            'telefono.regex' => 'El teléfono tiene un formato inválido.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'nombre' => 'nombre',
            'documento' => 'documento',
            'fecha_nacimiento' => 'fecha de nacimiento',
            'telefono' => 'teléfono',
        ];
    }

    /**
     * Obtener el ID del paciente desde el parámetro de la ruta
     */
    private function getPacienteId(): ?int
    {
        $pacienteParam = $this->route('paciente');

        if (!$pacienteParam) {
            return null;
        }

        // Si es un objeto modelo, obtener su ID
        if (is_object($pacienteParam) && isset($pacienteParam->id)) {
            return (int) $pacienteParam->id;
        }

        // Si es un string/int, convertirlo a entero
        if (is_numeric($pacienteParam)) {
            return (int) $pacienteParam;
        }

        return null;
    }
}
