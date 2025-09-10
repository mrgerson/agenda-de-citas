<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admision\AdmisionRequest;
use App\Services\Admision\AdmisionService;
use App\Services\Cita\CitaService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdmisionController extends Controller
{
    protected AdmisionService $admisionService;
    protected CitaService $citaService;

    public function __construct(AdmisionService $admisionService, CitaService $citaService)
    {
        $this->admisionService = $admisionService;
        $this->citaService = $citaService;
    }

    /**
     * Mostrar listado de admisiones
     */
    public function index(Request $request): View
    {
        $search = $request->get('search');
        $estado = $request->get('estado');

        if ($search) {
            $admisiones = $this->admisionService->searchPaginated($search);
        } elseif ($estado) {
            $admisiones = $this->admisionService->getByEstado($estado);
            // Convertir a paginated para mantener consistencia
            $admisiones = new \Illuminate\Pagination\LengthAwarePaginator(
                $admisiones->forPage(1, 15),
                $admisiones->count(),
                15,
                1,
                ['path' => request()->url(), 'pageName' => 'page']
            );
        } else {
            $admisiones = $this->admisionService->getAllPaginated();
        }

        $estadisticas = $this->admisionService->getEstadisticas();
        $citasPendientes = $this->admisionService->getCitasPendientesAdmision();

        return view('admisiones.index', compact('admisiones', 'search', 'estado', 'estadisticas', 'citasPendientes'));
    }

    /**
     * Mostrar formulario de creación
     */
    public function create(Request $request): View
    {
        $citaId = $request->get('cita_id');
        $cita = null;

        if ($citaId) {
            $cita = $this->citaService->findByIdOrFail($citaId);
        }

        $citasPendientes = $this->admisionService->getCitasPendientesAdmision();

        return view('admisiones.create', compact('citasPendientes', 'cita'));
    }

    /**
     * Guardar nueva admisión
     */
    public function store(AdmisionRequest $request): RedirectResponse
    {
        try {
            $this->admisionService->create($request->validated());

            return redirect()
                ->route('admisiones.index')
                ->with('success', 'Admisión registrada exitosamente.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Mostrar detalles de una admisión
     */
    public function show(int $id): View
    {
        $admision = $this->admisionService->findByIdOrFail($id);
        return view('admisiones.show', compact('admision'));
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(int $id): View
    {
        $admision = $this->admisionService->findByIdOrFail($id);
        return view('admisiones.edit', compact('admision'));
    }

    /**
     * Actualizar admisión
     */
    public function update(AdmisionRequest $request, int $id): RedirectResponse
    {
        try {
            $this->admisionService->update($id, $request->validated());

            return redirect()
                ->route('admisiones.index')
                ->with('success', 'Admisión actualizada exitosamente.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Eliminar admisión
     */
    public function destroy(int $id): RedirectResponse
    {
        try {
            $this->admisionService->delete($id);

            return redirect()
                ->route('admisiones.index')
                ->with('success', 'Admisión eliminada exitosamente.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error al eliminar la admisión: ' . $e->getMessage());
        }
    }

    /**
     * Crear admisión desde cita
     */
    public function createFromCita(int $citaId): RedirectResponse
    {
        try {
            $admision = $this->admisionService->createFromCita($citaId);

            return redirect()
                ->route('admisiones.show', $admision->id)
                ->with('success', 'Admisión creada desde la cita exitosamente.');
        } catch (\Exception $e) {
            return back()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Marcar como admitido
     */
    public function marcarAdmitido(Request $request, int $id): RedirectResponse
    {
        try {
            $notas = $request->input('notas');
            $this->admisionService->marcarComoAdmitido($id, $notas);

            return back()
                ->with('success', 'Paciente marcado como admitido exitosamente.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error al marcar como admitido: ' . $e->getMessage());
        }
    }

    /**
     * Marcar como no asistió
     */
    public function marcarNoAsistio(Request $request, int $id): RedirectResponse
    {
        try {
            $notas = $request->input('notas');
            $this->admisionService->marcarComoNoAsistio($id, $notas);

            return back()
                ->with('success', 'Paciente marcado como no asistió.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error al marcar como no asistió: ' . $e->getMessage());
        }
    }

    /**
     * Dashboard de admisiones (vista rápida del día)
     */
    public function dashboard(): View
    {
        $estadisticas = $this->admisionService->getEstadisticas();
        $admisionesHoy = $this->admisionService->getAdmisionesHoy();
        $citasPendientes = $this->admisionService->getCitasPendientesAdmision();

        return view('admisiones.dashboard', compact('estadisticas', 'admisionesHoy', 'citasPendientes'));
    }
}
