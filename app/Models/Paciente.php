<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Paciente extends Model
{
    use HasFactory;

    protected $table = 'pacientes';

    protected $fillable = [
        'nombre',
        'documento',
        'fecha_nacimiento',
        'telefono',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
    ];

    /**
     * Obtener la edad del paciente
     */
    public function getEdadAttribute(): int
    {
        return $this->fecha_nacimiento->age;
    }

    /**
     * Obtener la fecha de nacimiento formateada
     */
    public function getFechaNacimientoFormateadaAttribute(): string
    {
        return $this->fecha_nacimiento->format('d/m/Y');
    }

    /**
     * Scope para buscar por documento
     */
    public function scopeByDocumento($query, string $documento)
    {
        return $query->where('documento', $documento);
    }

    /**
     * Scope para buscar por nombre
     */
    public function scopeByNombre($query, string $nombre)
    {
        return $query->where('nombre', 'LIKE', "%{$nombre}%");
    }
}
