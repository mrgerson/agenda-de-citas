<?php

namespace App\Repositories\Contracts;

use App\Models\Cita;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface CitaRepositoryInterface
{
    /**
     * Obtener todas las citas paginadas
     */
    public function getAllPaginated(int $perPage = 15): LengthAwarePaginator;

    /**
     * Buscar citas paginadas
     */
    public function searchPaginated(string $search, int $perPage = 15): LengthAwarePaginator;

    /**
     * Encontrar cita por ID
     */
    public function findById(int $id): ?Cita;

    /**
     * Encontrar cita por ID o fallar
     */
    public function findByIdOrFail(int $id): Cita;

    /**
     * Crear nueva cita
     */
    public function create(array $data): Cita;

    /**
     * Actualizar cita
     */
    public function update(int $id, array $data): Cita;

    /**
     * Eliminar cita
     */
    public function delete(int $id): bool;

    /**
     * Obtener citas por fecha
     */
    public function getByFecha(string $fecha): Collection;

    /**
     * Obtener citas de hoy
     */
    public function getCitasHoy(): Collection;

    /**
     * Verificar disponibilidad de horario
     */
    public function isHorarioDisponible(string $fecha, string $hora, ?int $excludeId = null): bool;
}
