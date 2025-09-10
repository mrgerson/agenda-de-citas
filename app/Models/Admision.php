<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Admision extends Model
{
    protected $table = 'admisiones';

    protected $fillable = [
        'cita_id',
        'asistencia',
        'notas',
        'fecha_admision',
        'estado'
    ];

    protected $casts = [
        'asistencia' => 'boolean',
        'fecha_admision' => 'datetime',
    ];

    // Estados disponibles
    public const ESTADO_PENDIENTE = 'pendiente';
    public const ESTADO_ADMITIDO = 'admitido';
    public const ESTADO_NO_ASISTIO = 'no_asistio';

    public static function getEstados(): array
    {
        return [
            self::ESTADO_PENDIENTE => 'Pendiente',
            self::ESTADO_ADMITIDO => 'Admitido',
            self::ESTADO_NO_ASISTIO => 'No Asistió',
        ];
    }

    /**
     * Relación con Cita
     */
    public function cita(): BelongsTo
    {
        return $this->belongsTo(Cita::class);
    }

    /**
     * Obtener el paciente a través de la cita
     */
    public function paciente()
    {
        return $this->cita->paciente ?? null;
    }

    /**
     * Verificar si está pendiente de admisión
     */
    public function esPendiente(): bool
    {
        return $this->estado === self::ESTADO_PENDIENTE;
    }

    /**
     * Verificar si fue admitido
     */
    public function fueAdmitido(): bool
    {
        return $this->estado === self::ESTADO_ADMITIDO;
    }

    /**
     * Verificar si no asistió
     */
    public function noAsistio(): bool
    {
        return $this->estado === self::ESTADO_NO_ASISTIO;
    }

    /**
     * Marcar como admitido
     */
    public function marcarComoAdmitido(string $notas = null): void
    {
        $this->update([
            'asistencia' => true,
            'estado' => self::ESTADO_ADMITIDO,
            'fecha_admision' => now(),
            'notas' => $notas ?? $this->notas,
        ]);
    }

    /**
     * Marcar como no asistió
     */
    public function marcarComoNoAsistio(string $notas = null): void
    {
        $this->update([
            'asistencia' => false,
            'estado' => self::ESTADO_NO_ASISTIO,
            'fecha_admision' => now(),
            'notas' => $notas ?? $this->notas,
        ]);
    }

    /**
     * Obtener fecha de admisión formateada
     */
    public function getFechaAdmisionFormateadaAttribute(): ?string
    {
        return $this->fecha_admision ? $this->fecha_admision->format('d/m/Y H:i') : null;
    }

    /**
     * Scope para filtrar por estado
     */
    public function scopePorEstado($query, string $estado)
    {
        return $query->where('estado', $estado);
    }

    /**
     * Scope para admisiones de hoy
     */
    public function scopeHoy($query)
    {
        return $query->whereDate('created_at', today());
    }

    /**
     * Scope para pacientes que asistieron
     */
    public function scopeAsistieron($query)
    {
        return $query->where('asistencia', true);
    }

    /**
     * Scope para pacientes que no asistieron
     */
    public function scopeNoAsistieron($query)
    {
        return $query->where('asistencia', false);
    }
}
