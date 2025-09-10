@extends('layouts.app')

@section('title', 'Registrar Nueva Admisión')
@section('page-title', 'Registrar Nueva Admisión')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center space-x-4">
            <a href="{{ route('admisiones.index') }}" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <p class="text-sm text-gray-600">Registra la admisión de un paciente para su cita médica</p>
        </div>

        <!-- Form -->
        <div class="bg-white shadow rounded-lg">
            <form method="POST" action="{{ route('admisiones.store') }}" class="space-y-6 p-6">
                @csrf

                <!-- Selección de Cita -->
                <div>
                    <label for="cita_id" class="block text-sm font-medium text-gray-700">
                        Cita Médica *
                    </label>
                    <div class="mt-1">
                        <select id="cita_id" name="cita_id" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 @error('cita_id') border-red-300 @enderror">
                            <option value="">Selecciona una cita</option>
                            @if($cita)
                                <!-- Si viene de una cita específica -->
                                <option value="{{ $cita->id }}" selected>
                                    {{ $cita->paciente->nombre }} - {{ $cita->fecha->format('d/m/Y') }} {{ substr($cita->hora, 0, 5) }}
                                    ({{ $cita->paciente->documento }})
                                </option>
                            @else
                                @foreach($citasPendientes as $citaPendiente)
                                    <option value="{{ $citaPendiente->id }}" {{ old('cita_id') == $citaPendiente->id ? 'selected' : '' }}>
                                        {{ $citaPendiente->paciente->nombre }} - {{ $citaPendiente->fecha->format('d/m/Y') }} {{ substr($citaPendiente->hora, 0, 5) }}
                                        ({{ $citaPendiente->paciente->documento }})
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    @error('cita_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    @if(!$cita && $citasPendientes->isEmpty())
                        <p class="mt-1 text-sm text-yellow-600">
                            <i class="fas fa-exclamation-triangle mr-1"></i>
                            No hay citas confirmadas pendientes de admisión para hoy.
                            <a href="{{ route('citas.index') }}" class="text-emerald-600 hover:text-emerald-500">Ver todas las citas</a>
                        </p>
                    @endif
                </div>

                <!-- Información del paciente (se llena automáticamente) -->
                <div id="paciente-info" class="hidden bg-blue-50 border border-blue-200 rounded-md p-4">
                    <h4 class="text-sm font-medium text-blue-900 mb-2">Información del Paciente</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="font-medium text-blue-800">Nombre:</span>
                            <span id="paciente-nombre" class="text-blue-700"></span>
                        </div>
                        <div>
                            <span class="font-medium text-blue-800">Documento:</span>
                            <span id="paciente-documento" class="text-blue-700"></span>
                        </div>
                        <div>
                            <span class="font-medium text-blue-800">Fecha de Cita:</span>
                            <span id="cita-fecha" class="text-blue-700"></span>
                        </div>
                        <div>
                            <span class="font-medium text-blue-800">Hora:</span>
                            <span id="cita-hora" class="text-blue-700"></span>
                        </div>
                    </div>
                </div>

                <!-- Estado inicial -->
                <div>
                    <label for="estado" class="block text-sm font-medium text-gray-700">
                        Estado Inicial
                    </label>
                    <div class="mt-1">
                        <select id="estado" name="estado"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 @error('estado') border-red-300 @enderror">
                            <option value="pendiente" {{ old('estado', 'pendiente') == 'pendiente' ? 'selected' : '' }}>
                                Pendiente (El paciente aún no ha llegado)
                            </option>
                            <option value="admitido" {{ old('estado') == 'admitido' ? 'selected' : '' }}>
                                Admitido (El paciente ya llegó y fue admitido)
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
                        Asistencia del Paciente
                    </label>
                    <div class="space-y-2">
                        <label class="inline-flex items-center">
                            <input type="radio" name="asistencia" value="0"
                                class="form-radio text-emerald-600"
                                {{ old('asistencia', '0') == '0' ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">Pendiente (aún no ha llegado)</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="asistencia" value="1"
                                class="form-radio text-emerald-600"
                                {{ old('asistencia') == '1' ? 'checked' : '' }}>
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
                            placeholder="Registra observaciones sobre la admisión del paciente..."
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 @error('notas') border-red-300 @enderror">{{ old('notas') }}</textarea>
                    </div>
                    @error('notas')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Máximo 1000 caracteres. Puedes incluir observaciones sobre el estado del paciente, documentos presentados, etc.</p>
                </div>

                <!-- Información adicional -->
                <div class="bg-green-50 border border-green-200 rounded-md p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-green-400"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-green-800">
                                Información sobre Admisiones
                            </h3>
                            <div class="mt-2 text-sm text-green-700">
                                <ul class="list-disc list-inside space-y-1">
                                    <li>Las admisiones se crean para citas confirmadas</li>
                                    <li>Puedes cambiar el estado después de crear la admisión</li>
                                    <li>Las notas son opcionales pero recomendadas</li>
                                    <li>Una vez creada, podrás marcar asistencia desde el listado</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('admisiones.index') }}"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition duration-150 ease-in-out">
                        <i class="fas fa-times mr-2"></i>
                        Cancelar
                    </a>
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition duration-150 ease-in-out">
                        <i class="fas fa-save mr-2"></i>
                        Registrar Admisión
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const citaSelect = document.getElementById('cita_id');
            const pacienteInfo = document.getElementById('paciente-info');
            const estadoSelect = document.getElementById('estado');
            const asistenciaRadios = document.querySelectorAll('input[name="asistencia"]');

            // Datos de las citas (esto se podría mejorar con AJAX)
            const citasData = {
                @if($cita)
                    '{{ $cita->id }}': {
                        paciente_nombre: '{{ $cita->paciente->nombre }}',
                        paciente_documento: '{{ $cita->paciente->documento }}',
                        fecha: '{{ $cita->fecha->format('d/m/Y') }}',
                        hora: '{{ substr($cita->hora, 0, 5) }}'
                    }
                @else
                    @foreach($citasPendientes as $citaPendiente)
                        '{{ $citaPendiente->id }}': {
                            paciente_nombre: '{{ $citaPendiente->paciente->nombre }}',
                            paciente_documento: '{{ $citaPendiente->paciente->documento }}',
                            fecha: '{{ $citaPendiente->fecha->format('d/m/Y') }}',
                            hora: '{{ substr($citaPendiente->hora, 0, 5) }}'
                        },
                    @endforeach
                @endif
            };

            // Mostrar información del paciente al seleccionar cita
            citaSelect.addEventListener('change', function() {
                const citaId = this.value;
                if (citaId && citasData[citaId]) {
                    const data = citasData[citaId];
                    document.getElementById('paciente-nombre').textContent = data.paciente_nombre;
                    document.getElementById('paciente-documento').textContent = data.paciente_documento;
                    document.getElementById('cita-fecha').textContent = data.fecha;
                    document.getElementById('cita-hora').textContent = data.hora;
                    pacienteInfo.classList.remove('hidden');
                } else {
                    pacienteInfo.classList.add('hidden');
                }
            });

            // Sincronizar estado con asistencia
            estadoSelect.addEventListener('change', function() {
                if (this.value === 'admitido') {
                    asistenciaRadios[1].checked = true; // Asistió
                } else if (this.value === 'pendiente') {
                    asistenciaRadios[0].checked = true; // No asistió aún
                }
            });

            // Sincronizar asistencia con estado
            asistenciaRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === '1') {
                        estadoSelect.value = 'admitido';
                    } else {
                        estadoSelect.value = 'pendiente';
                    }
                });
            });

            // Si hay una cita preseleccionada, mostrar la información
            if (citaSelect.value) {
                citaSelect.dispatchEvent(new Event('change'));
            }
        });
    </script>
@endsection
