<?php

namespace App\Services\Cita;

use App\Models\Cita;
use App\Repositories\Contracts\CitaRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

class CitaService
{
    public function __construct(
        protected CitaRepositoryInterface $citaRepository
    ) {
    }

    /**
     * Obtener todas las citas paginadas
     */
    public function getAllPaginated(int $perPage = 15): LengthAwarePaginator
    {
        return $this->citaRepository->getAllPaginated($perPage);
    }

    /**
     * Buscar citas paginadas
     */
    public function searchPaginated(string $search, int $perPage = 15): LengthAwarePaginator
    {
        return $this->citaRepository->searchPaginated($search, $perPage);
    }

    /**
     * Encontrar cita por ID o fallar
     */
    public function findByIdOrFail(int $id): Cita
    {
        return $this->citaRepository->findByIdOrFail($id);
    }

    /**
     * Crear nueva cita
     */
    public function create(array $data): Cita
    {
        $this->validateCitaData($data);

        // Verificar disponibilidad del horario
        if (!$this->citaRepository->isHorarioDisponible($data['fecha'], $data['hora'])) {
            throw new InvalidArgumentException('El horario seleccionado no está disponible.');
        }

        return $this->citaRepository->create($data);
    }

    /**
     * Actualizar cita existente
     */
    public function update(int $id, array $data): Cita
    {
        $this->validateCitaData($data);

        // Verificar disponibilidad del horario (excluyendo la cita actual)
        if (!$this->citaRepository->isHorarioDisponible($data['fecha'], $data['hora'], $id)) {
            throw new InvalidArgumentException('El horario seleccionado no está disponible.');
        }

        return $this->citaRepository->update($id, $data);
    }

    /**
     * Eliminar cita
     */
    public function delete(int $id): bool
    {
        return $this->citaRepository->delete($id);
    }

    /**
     * Obtener citas por fecha
     */
    public function getCitasPorFecha(string $fecha): Collection
    {
        return $this->citaRepository->getByFecha($fecha);
    }

    /**
     * Obtener citas de hoy
     */
    public function getCitasHoy(): Collection
    {
        return $this->citaRepository->getCitasHoy();
    }

    /**
     * Cambiar estado de la cita
     */
    public function cambiarEstado(int $id, string $estado): Cita
    {
        if (!in_array($estado, array_keys(Cita::getEstados()))) {
            throw new InvalidArgumentException('Estado inválido.');
        }

        return $this->citaRepository->update($id, ['estado' => $estado]);
    }

    /**
     * Confirmar cita
     */
    public function confirmar(int $id): Cita
    {
        return $this->cambiarEstado($id, Cita::ESTADO_CONFIRMADA);
    }

    /**
     * Cancelar cita
     */
    public function cancelar(int $id): Cita
    {
        return $this->cambiarEstado($id, Cita::ESTADO_CANCELADA);
    }

    /**
     * Completar cita
     */
    public function completar(int $id): Cita
    {
        return $this->cambiarEstado($id, Cita::ESTADO_COMPLETADA);
    }

    /**
     * Validar datos de la cita
     */
    private function validateCitaData(array $data): void
    {
        // Validar que la fecha no sea en el pasado
        if (isset($data['fecha']) && strtotime($data['fecha']) < strtotime('today')) {
            throw new InvalidArgumentException('No se pueden agendar citas en fechas pasadas.');
        }

        // Validar horario de trabajo (ejemplo: 8:00 AM - 6:00 PM)
        if (isset($data['hora'])) {
            $hora = strtotime($data['hora']);
            $horaInicio = strtotime('08:00');
            $horaFin = strtotime('18:00');

            if ($hora < $horaInicio || $hora > $horaFin) {
                throw new InvalidArgumentException('El horario debe estar entre las 8:00 AM y 6:00 PM.');
            }
        }
    }
}
