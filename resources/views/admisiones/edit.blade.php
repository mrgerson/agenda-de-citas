@extends('layouts.app')

@section('title', 'Editar Admisión')
@section('page-title', 'Editar Admisión')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center space-x-4">
            <a href="{{ route('admisiones.show', $admision) }}" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <p class="text-sm text-gray-600">Modifica la información de la admisión de {{ $admision->cita->paciente->nombre }}</p>
        </div>

        <!-- Información actual -->
        <div class="bg-gray-50 border border-gray-200 rounded-md p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-info-circle text-gray-400"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-gray-800">Información actual de la admisión</h3>
                    <div class="mt-1 text-sm text-gray-600">
                        <p><strong>Estado actual:</strong>
                            @php
                                $estadoClasses = [
                                    'pendiente' => 'bg-yellow-100 text-yellow-800',
                                    'admitido' => 'bg-green-100 text-green-800',
                                    'no_asistio' => 'bg-red-100 text-red-800'
                                ];
                            @endphp
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $estadoClasses[$admision->estado] }}">
                                {{ ucfirst(str_replace('_', ' ', $admision->estado)) }}
                            </span>
                        </p>
                        <p><strong>Paciente:</strong> {{ $admision->cita->paciente->nombre }}</p>
                        <p><strong>Cita:</strong> {{ $admision->cita->fecha->format('d/m/Y') }} a las {{ substr($admision->cita->hora, 0, 5) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Form -->
        <div class="bg-white shadow rounded-lg">
            <form method="POST" action="{{ route('admisiones.update', $admision) }}" class="space-y-6 p-6">
                @csrf
                @method('PUT')

                <!-- Información de la cita (solo lectura) -->
                <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                    <h4 class="text-sm font-medium text-blue-900 mb-2">Información de la Cita</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="font-medium text-blue-800">Paciente:</span>
                            <span class="text-blue-700">{{ $admision->cita->paciente->nombre }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-blue-800">Documento:</span>
                            <span class="text-blue-700">{{ $admision->cita->paciente->documento }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-blue-800">Fecha:</span>
                            <span class="text-blue-700">{{ $admision->cita->fecha->format('d/m/Y') }}</span>
                        </div>
                        <div>
                            <span class="font-medium text-blue-800">Hora:</span>
                            <span class="text-blue-700">{{ substr($admision->cita->hora, 0, 5) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Campo oculto para cita_id -->
                <input type="hidden" name="cita_id" value="{{ $admision->cita_id }}">

                <!-- Estado -->
                <div>
                    <label for="estado" class="block text-sm font-medium text-gray-700">
                        Estado de la Admisión *
                    </label>
                    <div class="mt-1">
                        <select id="estado" name="estado" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 @error('estado') border-red-300 @enderror">
                            <option value="pendiente" {{ old('estado', $admision->estado) == 'pendiente' ? 'selected' : '' }}>
                                Pendiente - El paciente aún no ha llegado
                            </option>
                            <option value="admitido" {{ old('estado', $admision->estado) == 'admitido' ? 'selected' : '' }}>
                                Admitido - El paciente llegó y fue admitido
                            </option>
                            <option value="no_asistio" {{ old('estado', $admision->estado) == 'no_asistio' ? 'selected' : '' }}>
                                No Asistió - El paciente no llegó a su cita
                            </option>
                        </select>
                    </div>
                    @error('estado')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Asistencia -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        Asistencia del Paciente *
                    </label>
                    <div class="space-y-2">
                        <label class="inline-flex items-center">
                            <input type="radio" name="asistencia" value="0"
                                class="form-radio text-emerald-600"
                                {{ old('asistencia', $admision->asistencia ? '1' : '0') == '0' ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">No asistió / Pendiente</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="asistencia" value="1"
                                class="form-radio text-emerald-600"
                                {{ old('asistencia', $admision->asistencia ? '1' : '0') == '1' ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">Asistió (el paciente llegó)</span>
                        </label>
                    </div>
                    @error('asistencia')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Notas de Admisión -->
                <div>
                    <label for="notas" class="block text-sm font-medium text-gray-700">
                        Notas de Admisión
                    </label>
                    <div class="mt-1">
                        <textarea id="notas" name="notas" rows="4"
                            placeholder="Actualiza las observaciones sobre la admisión del paciente..."
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 @error('notas') border-red-300 @enderror">{{ old('notas', $admision->notas) }}</textarea>
                    </div>
                    @error('notas')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Máximo 1000 caracteres. Incluye cualquier observación relevante sobre el estado del paciente.</p>
                </div>

                <!-- Advertencias según el estado actual -->
                @if($admision->estado === 'admitido' || $admision->estado === 'no_asistio')
                    <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">
                                    Admisión ya procesada
                                </h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>Esta admisión ya fue procesada como "{{ ucfirst(str_replace('_', ' ', $admision->estado)) }}".
                                    Ten cuidado al modificar el estado, ya que esto puede afectar los registros médicos.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Información adicional -->
                <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-blue-400"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">
                                Información sobre la edición
                            </h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <ul class="list-disc list-inside space-y-1">
                                    <li>Los cambios se aplicarán inmediatamente</li>
                                    <li>El estado y la asistencia deben ser coherentes</li>
                                    <li>Las notas se pueden actualizar en cualquier momento</li>
                                    <li>No se puede cambiar la cita asociada</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('admisiones.show', $admision) }}"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition duration-150 ease-in-out">
                        <i class="fas fa-times mr-2"></i>
                        Cancelar
                    </a>
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition duration-150 ease-in-out">
                        <i class="fas fa-save mr-2"></i>
                        Actualizar Admisión
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const estadoSelect = document.getElementById('estado');
            const asistenciaRadios = document.querySelectorAll('input[name="asistencia"]');

            // Sincronizar estado con asistencia
            estadoSelect.addEventListener('change', function() {
                if (this.value === 'admitido') {
                    asistenciaRadios[1].checked = true; // Asistió
                } else if (this.value === 'no_asistio') {
                    asistenciaRadios[0].checked = true; // No asistió
                } else if (this.value === 'pendiente') {
                    asistenciaRadios[0].checked = true; // Pendiente (no asistió aún)
                }
            });

            // Sincronizar asistencia con estado
            asistenciaRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === '1') {
                        estadoSelect.value = 'admitido';
                    } else {
                        // Si no asistió, puede ser pendiente o no_asistio
                        // Mantener el estado actual si ya es no_asistio
                        if (estadoSelect.value === 'admitido') {
                            estadoSelect.value = 'pendiente';
                        }
                    }
                });
            });
        });
    </script>
@endsection
