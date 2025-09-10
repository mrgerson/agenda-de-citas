<?php

namespace App\Repositories\Eloquent;

use App\Models\Cita;
use App\Repositories\Contracts\CitaRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class CitaRepository implements CitaRepositoryInterface
{
    public function __construct(protected Cita $model)
    {
    }

    public function getAllPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model
            ->with('paciente')
            ->orderBy('fecha', 'desc')
            ->orderBy('hora', 'desc')
            ->paginate($perPage);
    }

    public function searchPaginated(string $search, int $perPage = 15): LengthAwarePaginator
    {
        return $this->model
            ->with('paciente')
            ->where(function ($query) use ($search) {
                $query->where('motivo', 'LIKE', "%{$search}%")
                    ->orWhere('estado', 'LIKE', "%{$search}%")
                    ->orWhereHas('paciente', function ($q) use ($search) {
                        $q->where('nombre', 'LIKE', "%{$search}%")
                          ->orWhere('documento', 'LIKE', "%{$search}%");
                    });
            })
            ->orderBy('fecha', 'desc')
            ->orderBy('hora', 'desc')
            ->paginate($perPage);
    }

    public function findById(int $id): ?Cita
    {
        return $this->model->with('paciente')->find($id);
    }

    public function findByIdOrFail(int $id): Cita
    {
        return $this->model->with('paciente')->findOrFail($id);
    }

    public function create(array $data): Cita
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): Cita
    {
        $cita = $this->findByIdOrFail($id);
        $cita->update($data);
        return $cita->fresh();
    }

    public function delete(int $id): bool
    {
        $cita = $this->findByIdOrFail($id);
        return $cita->delete();
    }

    public function getByFecha(string $fecha): Collection
    {
        return $this->model
            ->with('paciente')
            ->whereDate('fecha', $fecha)
            ->orderBy('hora')
            ->get();
    }

    public function getCitasHoy(): Collection
    {
        return $this->model
            ->with('paciente')
            ->whereDate('fecha', today())
            ->orderBy('hora')
            ->get();
    }

    public function isHorarioDisponible(string $fecha, string $hora, ?int $excludeId = null): bool
    {
        $query = $this->model
            ->where('fecha', $fecha)
            ->where('hora', $hora)
            ->whereNotIn('estado', ['cancelada']);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return !$query->exists();
    }
}
