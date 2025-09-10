@extends('layouts.app')

@section('title', 'Detalles de la Admisión')
@section('page-title', 'Detalles de la Admisión')

@section('content')
    <div class="space-y-6">
        <!-- Header con acciones -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admisiones.index') }}" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div>
                    <h2 class="text-lg font-medium text-gray-900">Admisión #{{ $admision->id }}</h2>
                    <p class="text-sm text-gray-600">{{ $admision->cita->paciente->nombre }}</p>
                </div>
            </div>

            <div class="flex items-center space-x-3">
                @if($admision->estado === 'pendiente')
                    <!-- Marcar como admitido -->
                    <button type="button" onclick="mostrarModalAdmitir()"
                        class="inline-flex items-center px-3 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <i class="fas fa-user-check mr-2"></i>
                        Marcar Admitido
                    </button>

                    <!-- Marcar como no asistió -->
                    <button type="button" onclick="mostrarModalNoAsistio()"
                        class="inline-flex items-center px-3 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        <i class="fas fa-user-times mr-2"></i>
                        No Asistió
                    </button>

                    <!-- Editar -->
                    <a href="{{ route('admisiones.edit', $admision) }}"
                        class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                        <i class="fas fa-edit mr-2"></i>
                        Editar
                    </a>
                @endif
            </div>
        </div>

        <!-- Estado actual -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4">
                <div class="flex items-center justify-center">
                    @php
                        $estadoConfig = [
                            'pendiente' => [
                                'class' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                'icon' => 'fas fa-clock',
                                'text' => 'Pendiente de Admisión'
                            ],
                            'admitido' => [
                                'class' => 'bg-green-100 text-green-800 border-green-200',
                                'icon' => 'fas fa-user-check',
                                'text' => 'Paciente Admitido'
                            ],
                            'no_asistio' => [
                                'class' => 'bg-red-100 text-red-800 border-red-200',
                                'icon' => 'fas fa-user-times',
                                'text' => 'Paciente No Asistió'
                            ]
                        ];
                        $config = $estadoConfig[$admision->estado];
                    @endphp
                    <div class="inline-flex items-center px-6 py-3 border {{ $config['class'] }} rounded-full">
                        <i class="{{ $config['icon'] }} mr-3 text-lg"></i>
                        <span class="text-lg font-semibold">{{ $config['text'] }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información principal -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Información de la admisión -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Detalles de la admisión -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Información de la Admisión</h3>
                    </div>
                    <div class="p-6">
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">ID de Admisión</dt>
                                <dd class="mt-1 text-sm text-gray-900">#{{ $admision->id }}</dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Estado</dt>
                                <dd class="mt-1">
                                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full {{ $config['class'] }}">
                                        <i class="{{ $config['icon'] }} mr-2 text-xs"></i>
                                        {{ ucfirst(str_replace('_', ' ', $admision->estado)) }}
                                    </span>
                                </dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Asistencia</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    @if($admision->asistencia)
                                        <span class="inline-flex items-center text-green-600">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            Asistió
                                        </span>
                                    @else
                                        <span class="inline-flex items-center text-red-600">
                                            <i class="fas fa-times-circle mr-1"></i>
                                            No asistió
                                        </span>
                                    @endif
                                </dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Fecha de Admisión</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    @if($admision->fecha_admision)
                                        <i class="fas fa-calendar-check mr-2 text-gray-400"></i>
                                        {{ $admision->fecha_admision->format('d/m/Y H:i') }}
                                    @else
                                        <span class="text-gray-400">Pendiente</span>
                                    @endif
                                </dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Registrada</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <i class="fas fa-plus-circle mr-2 text-gray-400"></i>
                                    {{ $admision->created_at->format('d/m/Y H:i') }}
                                </dd>
                            </div>

                            @if($admision->created_at != $admision->updated_at)
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Última actualización</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        <i class="fas fa-edit mr-2 text-gray-400"></i>
                                        {{ $admision->updated_at->format('d/m/Y H:i') }}
                                    </dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                </div>

                <!-- Información de la cita -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Información de la Cita</h3>
                    </div>
                    <div class="p-6">
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Fecha de la Cita</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <i class="fas fa-calendar-alt mr-2 text-gray-400"></i>
                                    {{ $admision->cita->fecha->format('d/m/Y') }}
                                    @if($admision->cita->esHoy())
                                        <span class="ml-2 inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-800">
                                            Hoy
                                        </span>
                                    @endif
                                </dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Hora de la Cita</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <i class="fas fa-clock mr-2 text-gray-400"></i>
                                    {{ substr($admision->cita->hora, 0, 5) }}
                                </dd>
                            </div>

                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500">Motivo de la Cita</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $admision->cita->motivo }}</dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Estado de la Cita</dt>
                                <dd class="mt-1">
                                    @php
                                        $estadoCitaClasses = [
                                            'programada' => 'bg-yellow-100 text-yellow-800',
                                            'confirmada' => 'bg-blue-100 text-blue-800',
                                            'cancelada' => 'bg-red-100 text-red-800',
                                            'completada' => 'bg-green-100 text-green-800'
                                        ];
                                    @endphp
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $estadoCitaClasses[$admision->cita->estado] }}">
                                        {{ ucfirst($admision->cita->estado) }}
                                    </span>
                                </dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Ver Cita</dt>
                                <dd class="mt-1">
                                    <a href="{{ route('citas.show', $admision->cita) }}"
                                        class="inline-flex items-center text-sm text-emerald-600 hover:text-emerald-500">
                                        <i class="fas fa-external-link-alt mr-1"></i>
                                        Ver detalles de la cita
                                    </a>
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Notas de admisión -->
                @if($admision->notas)
                    <div class="bg-white shadow rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Notas de Admisión</h3>
                        </div>
                        <div class="p-6">
                            <div class="prose prose-sm max-w-none">
                                <p class="text-gray-700 whitespace-pre-line">{{ $admision->notas }}</p>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Información del paciente -->
            <div class="space-y-6">
                <!-- Datos del paciente -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Información del Paciente</h3>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center space-x-4 mb-4">
                            <div class="flex-shrink-0">
                                <div class="h-12 w-12 rounded-full bg-emerald-100 flex items-center justify-center">
                                    <i class="fas fa-user text-emerald-600 text-lg"></i>
                                </div>
                            </div>
                            <div>
                                <h4 class="text-lg font-medium text-gray-900">{{ $admision->cita->paciente->nombre }}</h4>
                                <p class="text-sm text-gray-500">{{ $admision->cita->paciente->edad }} años</p>
                            </div>
                        </div>

                        <dl class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Documento</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $admision->cita->paciente->documento }}</dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Fecha de Nacimiento</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $admision->cita->paciente->fecha_nacimiento_formateada }}</dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Teléfono</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <a href="tel:{{ $admision->cita->paciente->telefono }}" class="text-emerald-600 hover:text-emerald-500">
                                        {{ $admision->cita->paciente->telefono }}
                                    </a>
                                </dd>
                            </div>
                        </dl>

                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <a href="{{ route('pacientes.show', $admision->cita->paciente) }}"
                                class="inline-flex items-center text-sm text-emerald-600 hover:text-emerald-500">
                                <i class="fas fa-external-link-alt mr-2"></i>
                                Ver perfil completo
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Acciones -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Acciones</h3>
                    </div>
                    <div class="p-6 space-y-3">
                        <a href="{{ route('admisiones.index') }}"
                            class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            <i class="fas fa-list mr-2"></i>
                            Ver todas las admisiones
                        </a>

                        <a href="{{ route('admisiones.create') }}"
                            class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            <i class="fas fa-plus mr-2"></i>
                            Nueva admisión
                        </a>

                        @if($admision->estado === 'pendiente')
                            <form method="POST" action="{{ route('admisiones.destroy', $admision) }}" class="w-full">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-full inline-flex items-center justify-center px-4 py-2 border border-red-300 rounded-md shadow-sm text-sm font-medium text-red-700 bg-white hover:bg-red-50"
                                    onclick="return confirm('¿Estás seguro de eliminar esta admisión? Esta acción no se puede deshacer.')">
                                    <i class="fas fa-trash mr-2"></i>
                                    Eliminar admisión
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para marcar como admitido -->
    <div id="modal-admitir" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form method="POST" action="{{ route('admisiones.marcar-admitido', $admision) }}">
                    @csrf
                    @method('PATCH')
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                                <i class="fas fa-user-check text-green-600"></i>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left flex-1">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    Marcar como Admitido
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        ¿Confirmas que el paciente <strong>{{ $admision->cita->paciente->nombre }}</strong> ha sido admitido?
                                    </p>
                                    <div class="mt-4">
                                        <label for="notas-admitir" class="block text-sm font-medium text-gray-700">
                                            Notas adicionales (opcional)
                                        </label>
                                        <textarea id="notas-admitir" name="notas" rows="3"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500"
                                            placeholder="Observaciones sobre la admisión...">{{ $admision->notas }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Confirmar Admisión
                        </button>
                        <button type="button" onclick="cerrarModal('modal-admitir')"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal para marcar como no asistió -->
    <div id="modal-no-asistio" class="fixed inset-0 z-50 hidden overflow-y-auto">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form method="POST" action="{{ route('admisiones.marcar-no-asistio', $admision) }}">
                    @csrf
                    @method('PATCH')
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                                <i class="fas fa-user-times text-red-600"></i>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left flex-1">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    Marcar como No Asistió
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        ¿Confirmas que el paciente <strong>{{ $admision->cita->paciente->nombre }}</strong> no asistió a su cita?
                                    </p>
                                    <div class="mt-4">
                                        <label for="notas-no-asistio" class="block text-sm font-medium text-gray-700">
                                            Motivo o notas (opcional)
                                        </label>
                                        <textarea id="notas-no-asistio" name="notas" rows="3"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-red-500 focus:border-red-500"
                                            placeholder="Motivo por el cual no asistió...">{{ $admision->notas }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Confirmar No Asistencia
                        </button>
                        <button type="button" onclick="cerrarModal('modal-no-asistio')"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function mostrarModalAdmitir() {
            document.getElementById('modal-admitir').classList.remove('hidden');
        }

        function mostrarModalNoAsistio() {
            document.getElementById('modal-no-asistio').classList.remove('hidden');
        }

        function cerrarModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        // Cerrar modal al hacer clic fuera
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('fixed')) {
                cerrarModal('modal-admitir');
                cerrarModal('modal-no-asistio');
            }
        });
    </script>
@endsection
