<?php

namespace App\Services\Paciente;

use App\Models\Paciente;
use App\Repositories\Contracts\PacienteRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PacienteService
{
    protected PacienteRepositoryInterface $pacienteRepository;

    public function __construct(PacienteRepositoryInterface $pacienteRepository)
    {
        $this->pacienteRepository = $pacienteRepository;
    }

    /**
     * Obtener todos los pacientes paginados
     */
    public function getAllPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return $this->pacienteRepository->getPaginated($perPage);
    }

    /**
     * Obtener todos los pacientes (sin paginación)
     */
    public function getAll(): Collection
    {
        return $this->pacienteRepository->getAll();
    }

    /**
     * Buscar pacientes con paginación
     */
    public function searchPaginated(string $search, int $perPage = 15): LengthAwarePaginator
    {
        return $this->pacienteRepository->searchPaginated($search, $perPage);
    }

    /**
     * Crear un nuevo paciente
     */
    public function create(array $data): Paciente
    {
        // Validar que el documento no exista
        if ($this->pacienteRepository->existsByDocumento($data['documento'])) {
            throw new \Exception('Ya existe un paciente con este documento.');
        }

        return $this->pacienteRepository->create($data);
    }

    /**
     * Actualizar un paciente
     */
    public function update(int $id, array $data): bool
    {
        $paciente = $this->pacienteRepository->findOrFail($id);

        // Validar que el documento no exista en otro paciente
        if (isset($data['documento']) && $data['documento'] !== $paciente->documento) {
            if ($this->pacienteRepository->existsByDocumento($data['documento'])) {
                throw new \Exception('Ya existe un paciente con este documento.');
            }
        }

        return $this->pacienteRepository->update($id, $data);
    }

    /**
     * Eliminar un paciente
     */
    public function delete(int $id): bool
    {
        return $this->pacienteRepository->delete($id);
    }

    /**
     * Encontrar un paciente por ID
     */
    public function findById(int $id): ?Paciente
    {
        return $this->pacienteRepository->find($id);
    }

    /**
     * Encontrar un paciente por ID o fallar
     */
    public function findByIdOrFail(int $id): Paciente
    {
        return $this->pacienteRepository->findOrFail($id);
    }

    /**
     * Buscar paciente por documento
     */
    public function findByDocumento(string $documento): ?Paciente
    {
        return $this->pacienteRepository->findByDocumento($documento);
    }

    /**
     * Obtener todos los pacientes para select
     */
    public function getAllForSelect(): Collection
    {
        return $this->pacienteRepository->all();
    }
}
