<?php

namespace App\Services\Admision;

use App\Models\Admision;
use App\Models\Cita;
use App\Repositories\Contracts\AdmisionRepositoryInterface;
use App\Repositories\Contracts\CitaRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

class AdmisionService
{
    public function __construct(
        protected AdmisionRepositoryInterface $admisionRepository,
        protected CitaRepositoryInterface $citaRepository
    ) {
    }

    /**
     * Obtener todas las admisiones paginadas
     */
    public function getAllPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return $this->admisionRepository->getAllPaginated($perPage);
    }

    /**
     * Buscar admisiones paginadas
     */
    public function searchPaginated(string $search, int $perPage = 15): LengthAwarePaginator
    {
        return $this->admisionRepository->searchPaginated($search, $perPage);
    }

    /**
     * Encontrar admisión por ID o fallar
     */
    public function findByIdOrFail(int $id): Admision
    {
        return $this->admisionRepository->findByIdOrFail($id);
    }

    /**
     * Encontrar admisión por cita
     */
    public function findByCita(int $citaId): ?Admision
    {
        return $this->admisionRepository->findByCita($citaId);
    }

    /**
     * Crear nueva admisión
     */
    public function create(array $data): Admision
    {
        $this->validateAdmisionData($data);

        // Verificar que la cita existe y está confirmada
        $cita = $this->citaRepository->findByIdOrFail($data['cita_id']);

        if ($cita->estado !== 'confirmada') {
            throw new InvalidArgumentException('Solo se pueden crear admisiones para citas confirmadas.');
        }

        // Verificar que no exista ya una admisión para esta cita
        if ($this->admisionRepository->findByCita($cita->id)) {
            throw new InvalidArgumentException('Ya existe una admisión para esta cita.');
        }

        return $this->admisionRepository->create($data);
    }

    /**
     * Actualizar admisión existente
     */
    public function update(int $id, array $data): Admision
    {
        $this->validateAdmisionData($data, $id);
        return $this->admisionRepository->update($id, $data);
    }

    /**
     * Eliminar admisión
     */
    public function delete(int $id): bool
    {
        return $this->admisionRepository->delete($id);
    }

    /**
     * Obtener admisiones de hoy
     */
    public function getAdmisionesHoy(): Collection
    {
        return $this->admisionRepository->getAdmisionesHoy();
    }

    /**
     * Obtener admisiones por estado
     */
    public function getByEstado(string $estado): Collection
    {
        if (!in_array($estado, array_keys(Admision::getEstados()))) {
            throw new InvalidArgumentException('Estado inválido.');
        }

        return $this->admisionRepository->getByEstado($estado);
    }

    /**
     * Obtener citas pendientes de admisión
     */
    public function getCitasPendientesAdmision(): Collection
    {
        return $this->admisionRepository->getCitasPendientesAdmision();
    }

    /**
     * Crear admisión desde una cita
     */
    public function createFromCita(int $citaId): Admision
    {
        $cita = $this->citaRepository->findByIdOrFail($citaId);

        if ($cita->estado !== 'confirmada') {
            throw new InvalidArgumentException('Solo se pueden crear admisiones para citas confirmadas.');
        }

        if ($this->admisionRepository->findByCita($citaId)) {
            throw new InvalidArgumentException('Ya existe una admisión para esta cita.');
        }

        return $this->admisionRepository->createFromCita($cita);
    }

    /**
     * Marcar paciente como admitido
     */
    public function marcarComoAdmitido(int $id, string $notas = null): Admision
    {
        $admision = $this->findByIdOrFail($id);
        $admision->marcarComoAdmitido($notas);
        return $admision->fresh(['cita.paciente']);
    }

    /**
     * Marcar paciente como no asistió
     */
    public function marcarComoNoAsistio(int $id, string $notas = null): Admision
    {
        $admision = $this->findByIdOrFail($id);
        $admision->marcarComoNoAsistio($notas);
        return $admision->fresh(['cita.paciente']);
    }

    /**
     * Obtener estadísticas de admisiones
     */
    public function getEstadisticas(): array
    {
        $hoy = $this->getAdmisionesHoy();

        return [
            'total_hoy' => $hoy->count(),
            'admitidos_hoy' => $hoy->where('estado', Admision::ESTADO_ADMITIDO)->count(),
            'no_asistieron_hoy' => $hoy->where('estado', Admision::ESTADO_NO_ASISTIO)->count(),
            'pendientes_hoy' => $hoy->where('estado', Admision::ESTADO_PENDIENTE)->count(),
            'citas_pendientes_admision' => $this->getCitasPendientesAdmision()->count(),
        ];
    }

    /**
     * Validar datos de la admisión
     */
    private function validateAdmisionData(array $data, ?int $excludeId = null): void
    {
        // Validaciones adicionales si son necesarias
        if (isset($data['estado']) && !in_array($data['estado'], array_keys(Admision::getEstados()))) {
            throw new InvalidArgumentException('Estado inválido.');
        }
    }
}
