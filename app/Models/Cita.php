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
        'hora' => 'datetime:H:i',
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
        return $this->fecha->format('d/m/Y') . ' a las ' . $this->hora->format('H:i');
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
        $fechaHoraCita = Carbon::parse($this->fecha->format('Y-m-d') . ' ' . $this->hora->format('H:i:s'));
        return $fechaHoraCita->isPast();
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
