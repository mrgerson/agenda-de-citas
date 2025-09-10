<?php

namespace App\Repositories\Eloquent;

use App\Models\Admision;
use App\Models\Cita;
use App\Repositories\Contracts\AdmisionRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class AdmisionRepository implements AdmisionRepositoryInterface
{
    public function __construct(protected Admision $model)
    {
    }

    public function getAllPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model
            ->with(['cita.paciente'])
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    public function searchPaginated(string $search, int $perPage = 15): LengthAwarePaginator
    {
        return $this->model
            ->with(['cita.paciente'])
            ->where(function ($query) use ($search) {
                $query->where('notas', 'LIKE', "%{$search}%")
                    ->orWhere('estado', 'LIKE', "%{$search}%")
                    ->orWhereHas('cita.paciente', function ($q) use ($search) {
                        $q->where('nombre', 'LIKE', "%{$search}%")
                          ->orWhere('documento', 'LIKE', "%{$search}%");
                    });
            })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    public function findById(int $id): ?Admision
    {
        return $this->model->with(['cita.paciente'])->find($id);
    }

    public function findByIdOrFail(int $id): Admision
    {
        return $this->model->with(['cita.paciente'])->findOrFail($id);
    }

    public function findByCita(int $citaId): ?Admision
    {
        return $this->model->with(['cita.paciente'])->where('cita_id', $citaId)->first();
    }

    public function create(array $data): Admision
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): Admision
    {
        $admision = $this->findByIdOrFail($id);
        $admision->update($data);
        return $admision->fresh(['cita.paciente']);
    }

    public function delete(int $id): bool
    {
        $admision = $this->findByIdOrFail($id);
        return $admision->delete();
    }

    public function getAdmisionesHoy(): Collection
    {
        return $this->model
            ->with(['cita.paciente'])
            ->whereHas('cita', function ($query) {
                $query->whereDate('fecha', today());
            })
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getByEstado(string $estado): Collection
    {
        return $this->model
            ->with(['cita.paciente'])
            ->where('estado', $estado)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getCitasPendientesAdmision(): Collection
    {
        return Cita::with(['paciente'])
            ->whereIn('estado', ['confirmada'])
            ->whereDate('fecha', today())
            ->doesntHave('admision')
            ->orderBy('hora')
            ->get();
    }

    public function createFromCita(Cita $cita): Admision
    {
        return $this->create([
            'cita_id' => $cita->id,
            'asistencia' => false,
            'estado' => Admision::ESTADO_PENDIENTE,
        ]);
    }
}
