<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cita\CitaRequest;
use App\Services\Cita\CitaService;
use App\Services\Paciente\PacienteService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CitaController extends Controller
{
    protected CitaService $citaService;
    protected PacienteService $pacienteService;

    public function __construct(CitaService $citaService, PacienteService $pacienteService)
    {
        $this->citaService = $citaService;
        $this->pacienteService = $pacienteService;
    }

    /**
     * Mostrar listado de citas
     */
    public function index(Request $request): View
    {
        $search = $request->get('search');

        if ($search) {
            $citas = $this->citaService->searchPaginated($search);
        } else {
            $citas = $this->citaService->getAllPaginated();
        }

        return view('citas.index', compact('citas', 'search'));
    }

    /**
     * Mostrar formulario de creación
     */
    public function create(): View
    {
        $pacientes = $this->pacienteService->getAll();
        return view('citas.create', compact('pacientes'));
    }

    /**
     * Guardar nueva cita
     */
    public function store(CitaRequest $request): RedirectResponse
    {
        try {
            $this->citaService->create($request->validated());

            return redirect()
                ->route('citas.index')
                ->with('success', 'Cita agendada exitosamente.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Mostrar detalles de una cita
     */
    public function show(int $id): View
    {
        $cita = $this->citaService->findByIdOrFail($id);
        return view('citas.show', compact('cita'));
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(int $id): View
    {
        $cita = $this->citaService->findByIdOrFail($id);
        $pacientes = $this->pacienteService->getAll();
        return view('citas.edit', compact('cita', 'pacientes'));
    }

    /**
     * Actualizar cita
     */
    public function update(CitaRequest $request, int $id): RedirectResponse
    {
        try {
            $this->citaService->update($id, $request->validated());

            return redirect()
                ->route('citas.index')
                ->with('success', 'Cita actualizada exitosamente.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Eliminar cita
     */
    public function destroy(int $id): RedirectResponse
    {
        try {
            $this->citaService->delete($id);

            return redirect()
                ->route('citas.index')
                ->with('success', 'Cita eliminada exitosamente.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error al eliminar la cita: ' . $e->getMessage());
        }
    }

    /**
     * Confirmar cita
     */
    public function confirmar(int $id): RedirectResponse
    {
        try {
            $this->citaService->confirmar($id);

            return back()
                ->with('success', 'Cita confirmada exitosamente.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error al confirmar la cita: ' . $e->getMessage());
        }
    }

    /**
     * Cancelar cita
     */
    public function cancelar(int $id): RedirectResponse
    {
        try {
            $this->citaService->cancelar($id);

            return back()
                ->with('success', 'Cita cancelada exitosamente.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error al cancelar la cita: ' . $e->getMessage());
        }
    }

    /**
     * Completar cita
     */
    public function completar(int $id): RedirectResponse
    {
        try {
            $this->citaService->completar($id);

            return back()
                ->with('success', 'Cita completada exitosamente.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error al completar la cita: ' . $e->getMessage());
        }
    }
}
