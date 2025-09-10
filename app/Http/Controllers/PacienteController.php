<?php

namespace App\Http\Controllers;

use App\Http\Requests\Paciente\PacienteRequest;
use App\Services\Paciente\PacienteService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PacienteController extends Controller
{
    protected PacienteService $pacienteService;

    public function __construct(PacienteService $pacienteService)
    {
        $this->pacienteService = $pacienteService;
    }

    /**
     * Mostrar listado de pacientes
     */
    public function index(Request $request): View
    {
        $search = $request->get('search');

        if ($search) {
            $pacientes = $this->pacienteService->searchPaginated($search);
        } else {
            $pacientes = $this->pacienteService->getAllPaginated();
        }

        return view('pacientes.index', compact('pacientes', 'search'));
    }

    /**
     * Mostrar formulario de creación
     */
    public function create(): View
    {
        return view('pacientes.create');
    }

    /**
     * Guardar nuevo paciente
     */
    public function store(PacienteRequest $request): RedirectResponse
    {
        try {
            $this->pacienteService->create($request->validated());

            return redirect()
                ->route('pacientes.index')
                ->with('success', 'Paciente creado exitosamente.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Mostrar detalles de un paciente
     */
    public function show(int $id): View
    {
        $paciente = $this->pacienteService->findByIdOrFail($id);
        return view('pacientes.show', compact('paciente'));
    }

    /**
     * Mostrar formulario de edición
     */
    public function edit(int $id): View
    {
        $paciente = $this->pacienteService->findByIdOrFail($id);
        return view('pacientes.edit', compact('paciente'));
    }

    /**
     * Actualizar paciente
     */
    public function update(PacienteRequest $request, $id): RedirectResponse
    {
        try {
            $this->pacienteService->update($id, $request->validated());

            return redirect()
                ->route('pacientes.index')
                ->with('success', 'Paciente actualizado exitosamente.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Eliminar paciente
     */
    public function destroy(int $id): RedirectResponse
    {
        try {
            $this->pacienteService->delete($id);

            return redirect()
                ->route('pacientes.index')
                ->with('success', 'Paciente eliminado exitosamente.');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error al eliminar el paciente: ' . $e->getMessage());
        }
    }
}
