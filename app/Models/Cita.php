<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Cita extends Model
{
    protected $fillable = [
        'paciente_id',
        'fecha',
        'hora',
        'motivo',
        'estado'
    ];

    protected $casts = [
        'fecha' => 'date',
    ];

    // Estados disponibles
    public const ESTADO_PROGRAMADA = 'programada';
    public const ESTADO_CONFIRMADA = 'confirmada';
    public const ESTADO_CANCELADA = 'cancelada';
    public const ESTADO_COMPLETADA = 'completada';

    public static function getEstados(): array
    {
        return [
            self::ESTADO_PROGRAMADA => 'Programada',
            self::ESTADO_CONFIRMADA => 'Confirmada',
            self::ESTADO_CANCELADA => 'Cancelada',
            self::ESTADO_COMPLETADA => 'Completada',
        ];
    }

    /**
     * Relación con Paciente
     */
    public function paciente(): BelongsTo
    {
        return $this->belongsTo(Paciente::class);
    }

    /**
     * Obtener fecha y hora formateada
     */
    public function getFechaHoraFormateadaAttribute(): string
    {
        $horaLimpia = substr($this->hora, 0, 5); // Tomar solo HH:MM
        return $this->fecha->format('d/m/Y') . ' a las ' . $horaLimpia;
    }

    /**
     * Verificar si la cita es hoy
     */
    public function esHoy(): bool
    {
        return $this->fecha->isToday();
    }

    /**
     * Verificar si la cita ya pasó
     */
    public function yaPaso(): bool
    {
        try {
            // Limpiar la hora para obtener solo HH:MM
            $horaLimpia = substr($this->hora, 0, 5); // Tomar solo los primeros 5 caracteres (HH:MM)
            $fechaHoraCita = Carbon::parse($this->fecha->format('Y-m-d') . ' ' . $horaLimpia);
            return $fechaHoraCita->isPast();
        } catch (\Exception $e) {
            // Si hay error en el parsing, asumir que no ha pasado
            return false;
        }
    }

    /**
     * Scope para filtrar por estado
     */
    public function scopePorEstado($query, string $estado)
    {
        return $query->where('estado', $estado);
    }

    /**
     * Scope para filtrar por fecha
     */
    public function scopePorFecha($query, $fecha)
    {
        return $query->whereDate('fecha', $fecha);
    }

    /**
     * Scope para citas de hoy
     */
    public function scopeHoy($query)
    {
        return $query->whereDate('fecha', today());
    }
}
