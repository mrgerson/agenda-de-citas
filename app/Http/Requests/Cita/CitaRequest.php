<?php

namespace App\Http\Requests\Cita;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CitaRequest extends FormRequest
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
        $citaId = $this->getCitaId();

        return [
            'paciente_id' => [
                'required',
                'integer',
                'exists:pacientes,id',
            ],
            'fecha' => [
                'required',
                'date',
                'after_or_equal:today',
            ],
            'hora' => [
                'required',
                'date_format:H:i',
                'after_or_equal:08:00',
                'before_or_equal:18:00',
                // Validación personalizada para disponibilidad
                Rule::unique('citas')->where(function ($query) {
                    return $query->where('fecha', $this->fecha)
                                ->where('hora', $this->hora)
                                ->whereNotIn('estado', ['cancelada']);
                })->ignore($citaId),
            ],
            'motivo' => [
                'required',
                'string',
                'max:500',
                'min:10',
            ],
            'estado' => [
                'sometimes',
                'string',
                Rule::in(['programada', 'confirmada', 'cancelada', 'completada']),
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'paciente_id.required' => 'Debe seleccionar un paciente.',
            'paciente_id.exists' => 'El paciente seleccionado no existe.',

            'fecha.required' => 'La fecha es obligatoria.',
            'fecha.date' => 'La fecha debe ser válida.',
            'fecha.after_or_equal' => 'No se pueden agendar citas en fechas pasadas.',

            'hora.required' => 'La hora es obligatoria.',
            'hora.date_format' => 'El formato de hora debe ser HH:MM (ej: 14:30).',
            'hora.after_or_equal' => 'El horario debe ser a partir de las 8:00 AM.',
            'hora.before_or_equal' => 'El horario debe ser antes de las 6:00 PM.',
            'hora.unique' => 'Ya existe una cita programada para esa fecha y hora.',

            'motivo.required' => 'El motivo de la cita es obligatorio.',
            'motivo.string' => 'El motivo debe ser texto.',
            'motivo.max' => 'El motivo no puede tener más de 500 caracteres.',
            'motivo.min' => 'El motivo debe tener al menos 10 caracteres.',

            'estado.in' => 'El estado seleccionado no es válido.',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'paciente_id' => 'paciente',
            'fecha' => 'fecha',
            'hora' => 'hora',
            'motivo' => 'motivo de la cita',
            'estado' => 'estado',
        ];
    }

    /**
     * Obtener el ID de la cita desde el parámetro de la ruta
     */
    private function getCitaId(): ?int
    {
        $citaParam = $this->route('cita');

        if (!$citaParam) {
            return null;
        }

        // Si es un objeto modelo, obtener su ID
        if (is_object($citaParam) && isset($citaParam->id)) {
            return (int) $citaParam->id;
        }

        // Si es un string/int, convertirlo a entero
        if (is_numeric($citaParam)) {
            return (int) $citaParam;
        }

        return null;
    }
}
