<?php

namespace App\Repositories\Contracts;

use App\Models\Admision;
use App\Models\Cita;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface AdmisionRepositoryInterface
{
    /**
     * Obtener todas las admisiones paginadas
     */
    public function getAllPaginated(int $perPage = 15): LengthAwarePaginator;

    /**
     * Buscar admisiones paginadas
     */
    public function searchPaginated(string $search, int $perPage = 15): LengthAwarePaginator;

    /**
     * Encontrar admisión por ID
     */
    public function findById(int $id): ?Admision;

    /**
     * Encontrar admisión por ID o fallar
     */
    public function findByIdOrFail(int $id): Admision;

    /**
     * Encontrar admisión por cita
     */
    public function findByCita(int $citaId): ?Admision;

    /**
     * Crear nueva admisión
     */
    public function create(array $data): Admision;

    /**
     * Actualizar admisión
     */
    public function update(int $id, array $data): Admision;

    /**
     * Eliminar admisión
     */
    public function delete(int $id): bool;

    /**
     * Obtener admisiones de hoy
     */
    public function getAdmisionesHoy(): Collection;

    /**
     * Obtener admisiones por estado
     */
    public function getByEstado(string $estado): Collection;

    /**
     * Obtener citas pendientes de admisión (citas confirmadas sin admisión)
     */
    public function getCitasPendientesAdmision(): Collection;

    /**
     * Crear admisión desde cita
     */
    public function createFromCita(Cita $cita): Admision;
}
