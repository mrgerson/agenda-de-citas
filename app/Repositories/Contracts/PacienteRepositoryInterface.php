<?php

namespace App\Repositories\Contracts;

use App\Models\Paciente;
use Illuminate\Database\Eloquent\Collection;

interface PacienteRepositoryInterface
{
    // Métodos CRUD básicos
    public function find(int $id): ?Paciente;
    public function findOrFail(int $id): Paciente;
    public function all(): Collection;
    public function create(array $data): Paciente;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;

    // Métodos específicos de Paciente
    public function findByDocumento(string $documento): ?Paciente;
    public function searchByNombre(string $nombre): Collection;
    public function getAll(): Collection;
    public function existsByDocumento(string $documento): bool;
    public function getPaginated(int $perPage = 15): \Illuminate\Contracts\Pagination\LengthAwarePaginator;
    public function searchPaginated(string $search, int $perPage = 15): \Illuminate\Contracts\Pagination\LengthAwarePaginator;
}
