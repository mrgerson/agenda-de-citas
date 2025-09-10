@extends('layouts.app')

@section('title', 'Agendar Nueva Cita')
@section('page-title', 'Agendar Nueva Cita')

@section('content')
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center space-x-4">
            <a href="{{ route('citas.index') }}" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <p class="text-sm text-gray-600">Programa una nueva cita médica</p>
        </div>

        <!-- Form -->
        <div class="bg-white shadow rounded-lg">
            <form method="POST" action="{{ route('citas.store') }}" class="space-y-6 p-6">
                @csrf

                <!-- Selección de Paciente -->
                <div>
                    <label for="paciente_id" class="block text-sm font-medium text-gray-700">
                        Paciente *
                    </label>
                    <div class="mt-1">
                        <select id="paciente_id" name="paciente_id" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 @error('paciente_id') border-red-300 @enderror">
                            <option value="">Selecciona un paciente</option>
                            @foreach($pacientes as $paciente)
                                <option value="{{ $paciente->id }}" {{ old('paciente_id') == $paciente->id ? 'selected' : '' }}>
                                    {{ $paciente->nombre }} - {{ $paciente->documento }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @error('paciente_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Fecha y Hora -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Fecha -->
                    <div>
                        <label for="fecha" class="block text-sm font-medium text-gray-700">
                            Fecha *
                        </label>
                        <div class="mt-1">
                            <input type="date" id="fecha" name="fecha" value="{{ old('fecha') }}" required
                                min="{{ date('Y-m-d') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 @error('fecha') border-red-300 @enderror">
                        </div>
                        @error('fecha')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Hora -->
                    <div>
                        <label for="hora" class="block text-sm font-medium text-gray-700">
                            Hora *
                        </label>
                        <div class="mt-1">
                            <select id="hora" name="hora" required
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 @error('hora') border-red-300 @enderror">
                                <option value="">Selecciona una hora</option>
                                @for($hour = 8; $hour <= 17; $hour++)
                                    @for($minute = 0; $minute < 60; $minute += 30)
                                        @php
                                            $time = sprintf('%02d:%02d', $hour, $minute);
                                            $timeDisplay = sprintf('%02d:%02d %s',
                                                $hour > 12 ? $hour - 12 : ($hour == 0 ? 12 : $hour),
                                                $minute,
                                                $hour >= 12 ? 'PM' : 'AM'
                                            );
                                        @endphp
                                        <option value="{{ $time }}" {{ old('hora') == $time ? 'selected' : '' }}>
                                            {{ $timeDisplay }}
                                        </option>
                                    @endfor
                                @endfor
                            </select>
                        </div>
                        @error('hora')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Horario de atención: 8:00 AM - 6:00 PM</p>
                    </div>
                </div>

                <!-- Motivo -->
                <div>
                    <label for="motivo" class="block text-sm font-medium text-gray-700">
                        Motivo de la Cita *
                    </label>
                    <div class="mt-1">
                        <textarea id="motivo" name="motivo" rows="4" required
                            placeholder="Describe el motivo de la consulta médica..."
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 @error('motivo') border-red-300 @enderror">{{ old('motivo') }}</textarea>
                    </div>
                    @error('motivo')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <p class="mt-1 text-xs text-gray-500">Mínimo 10 caracteres, máximo 500 caracteres</p>
                </div>

                <!-- Información adicional -->
                <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-blue-400"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">
                                Información importante
                            </h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <ul class="list-disc list-inside space-y-1">
                                    <li>Las citas se programan con estado "Programada" por defecto</li>
                                    <li>El paciente recibirá una notificación de confirmación</li>
                                    <li>Puedes modificar o cancelar la cita antes de la fecha programada</li>
                                    <li>Horario de atención: Lunes a Viernes de 8:00 AM a 6:00 PM</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones -->
                <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('citas.index') }}"
                        class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition duration-150 ease-in-out">
                        <i class="fas fa-times mr-2"></i>
                        Cancelar
                    </a>
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition duration-150 ease-in-out">
                        <i class="fas fa-calendar-plus mr-2"></i>
                        Agendar Cita
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Script para validar disponibilidad de horario en tiempo real
        document.addEventListener('DOMContentLoaded', function() {
            const fechaInput = document.getElementById('fecha');
            const horaSelect = document.getElementById('hora');

            function checkAvailability() {
                const fecha = fechaInput.value;
                const hora = horaSelect.value;

                if (fecha && hora) {
                    // Aquí podrías hacer una petición AJAX para verificar disponibilidad
                    // Por ahora solo mostramos un mensaje visual
                    console.log('Verificando disponibilidad para:', fecha, hora);
                }
            }

            fechaInput.addEventListener('change', checkAvailability);
            horaSelect.addEventListener('change', checkAvailability);
        });
    </script>
@endsection
