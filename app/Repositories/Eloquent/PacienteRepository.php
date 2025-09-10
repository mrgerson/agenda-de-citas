<?php

namespace App\Repositories\Eloquent;

use App\Models\Paciente;
use App\Repositories\Contracts\PacienteRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PacienteRepository implements PacienteRepositoryInterface
{
    protected Paciente $model;

    public function __construct(Paciente $model)
    {
        $this->model = $model;
    }

    // Métodos CRUD básicos
    public function find(int $id): ?Paciente
    {
        return $this->model->find($id);
    }

    public function findOrFail(int $id): Paciente
    {
        return $this->model->findOrFail($id);
    }

    public function all(): Collection
    {
        return $this->model->orderBy('nombre')->get();
    }

    public function create(array $data): Paciente
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): bool
    {
        $paciente = $this->findOrFail($id);
        return $paciente->update($data);
    }

    public function delete(int $id): bool
    {
        $paciente = $this->findOrFail($id);
        return $paciente->delete();
    }

    // Métodos específicos de Paciente
    public function findByDocumento(string $documento): ?Paciente
    {
        return $this->model->where('documento', $documento)->first();
    }

    public function searchByNombre(string $nombre): Collection
    {
        return $this->model->byNombre($nombre)->orderBy('nombre')->get();
    }

    public function existsByDocumento(string $documento): bool
    {
        return $this->model->where('documento', $documento)->exists();
    }

    public function getPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->orderBy('id', 'desc')->paginate($perPage);
    }

    public function searchPaginated(string $search, int $perPage = 15): LengthAwarePaginator
    {
        return $this->model
            ->where('nombre', 'LIKE', "%{$search}%")
            ->orWhere('documento', 'LIKE', "%{$search}%")
            ->orderBy('id', 'desc')
            ->paginate($perPage);
    }
}
