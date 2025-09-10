@extends('layouts.app')

@section('title', 'Detalles de la Cita')
@section('page-title', 'Detalles de la Cita')

@section('content')
    <div class="space-y-6">
        <!-- Header con acciones -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
            <div class="flex items-center space-x-4">
                <a href="{{ route('citas.index') }}" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </a>
                <div>
                    <h2 class="text-lg font-medium text-gray-900">Cita #{{ $cita->id }}</h2>
                    <p class="text-sm text-gray-600">{{ $cita->fecha_hora_formateada }}</p>
                </div>
            </div>

            <div class="flex items-center space-x-3">
                @if($cita->estado !== 'completada' && $cita->estado !== 'cancelada')
                    <a href="{{ route('citas.edit', $cita) }}"
                        class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                        <i class="fas fa-edit mr-2"></i>
                        Editar
                    </a>
                @endif

                <!-- Botones de acción según estado -->
                @if($cita->estado === 'programada')
                    <form method="POST" action="{{ route('citas.confirmar', $cita) }}" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="inline-flex items-center px-3 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                            onclick="return confirm('¿Confirmar esta cita?')">
                            <i class="fas fa-check-circle mr-2"></i>
                            Confirmar
                        </button>
                    </form>
                @elseif($cita->estado === 'confirmada')
                    <form method="POST" action="{{ route('citas.completar', $cita) }}" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="inline-flex items-center px-3 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                            onclick="return confirm('¿Marcar esta cita como completada?')">
                            <i class="fas fa-check-double mr-2"></i>
                            Completar
                        </button>
                    </form>
                @endif

                @if($cita->estado !== 'cancelada' && $cita->estado !== 'completada')
                    <form method="POST" action="{{ route('citas.cancelar', $cita) }}" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="inline-flex items-center px-3 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                            onclick="return confirm('¿Cancelar esta cita?')">
                            <i class="fas fa-times-circle mr-2"></i>
                            Cancelar
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <!-- Información principal -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Información de la cita -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Estado y fecha -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Información de la Cita</h3>
                    </div>
                    <div class="p-6">
                        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Estado</dt>
                                <dd class="mt-1">
                                    @php
                                        $estadoClasses = [
                                            'programada' => 'bg-yellow-100 text-yellow-800',
                                            'confirmada' => 'bg-blue-100 text-blue-800',
                                            'cancelada' => 'bg-red-100 text-red-800',
                                            'completada' => 'bg-green-100 text-green-800'
                                        ];
                                    @endphp
                                    <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full {{ $estadoClasses[$cita->estado] }}">
                                        <i class="fas fa-circle mr-2 text-xs"></i>
                                        {{ ucfirst($cita->estado) }}
                                    </span>
                                </dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Fecha</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <i class="fas fa-calendar-alt mr-2 text-gray-400"></i>
                                    {{ $cita->fecha->format('l, d \d\e F \d\e Y') }}
                                    @if($cita->esHoy())
                                        <span class="ml-2 inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-emerald-100 text-emerald-800">
                                            Hoy
                                        </span>
                                    @endif
                                </dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Hora</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <i class="fas fa-clock mr-2 text-gray-400"></i>
                                    {{ $cita->hora->format('g:i A') }}
                                    @if($cita->yaPaso())
                                        <span class="ml-2 text-xs text-red-600">(Vencida)</span>
                                    @endif
                                </dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Creada</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <i class="fas fa-plus-circle mr-2 text-gray-400"></i>
                                    {{ $cita->created_at->format('d/m/Y H:i') }}
                                </dd>
                            </div>

                            @if($cita->created_at != $cita->updated_at)
                                <div class="sm:col-span-2">
                                    <dt class="text-sm font-medium text-gray-500">Última actualización</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        <i class="fas fa-edit mr-2 text-gray-400"></i>
                                        {{ $cita->updated_at->format('d/m/Y H:i') }}
                                    </dd>
                                </div>
                            @endif
                        </dl>
                    </div>
                </div>

                <!-- Motivo de la cita -->
                <div class="bg-white shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Motivo de la Cita</h3>
                    </div>
                    <div class="p-6">
                        <div class="prose prose-sm max-w-none">
                            <p class="text-gray-700 whitespace-pre-line">{{ $cita->motivo }}</p>
                        </div>
                    </div>
                </div>
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
                                <h4 class="text-lg font-medium text-gray-900">{{ $cita->paciente->nombre }}</h4>
                                <p class="text-sm text-gray-500">{{ $cita->paciente->edad }} años</p>
                            </div>
                        </div>

                        <dl class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Documento</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $cita->paciente->documento }}</dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Fecha de Nacimiento</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $cita->paciente->fecha_nacimiento_formateada }}</dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">Teléfono</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <a href="tel:{{ $cita->paciente->telefono }}" class="text-emerald-600 hover:text-emerald-500">
                                        {{ $cita->paciente->telefono }}
                                    </a>
                                </dd>
                            </div>
                        </dl>

                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <a href="{{ route('pacientes.show', $cita->paciente) }}"
                                class="inline-flex items-center text-sm text-emerald-600 hover:text-emerald-500">
                                <i class="fas fa-external-link-alt mr-2"></i>
                                Ver perfil completo
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Citas relacionadas -->
                @if($cita->paciente->citasActivas->count() > 1)
                    <div class="bg-white shadow rounded-lg">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Otras Citas del Paciente</h3>
                        </div>
                        <div class="p-6">
                            <div class="space-y-3">
                                @foreach($cita->paciente->citasActivas->where('id', '!=', $cita->id)->take(3) as $otraCita)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">
                                                {{ $otraCita->fecha->format('d/m/Y') }} - {{ $otraCita->hora->format('H:i') }}
                                            </p>
                                            <p class="text-xs text-gray-500">{{ Str::limit($otraCita->motivo, 30) }}</p>
                                        </div>
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                            @if($otraCita->estado === 'programada') bg-yellow-100 text-yellow-800
                                            @elseif($otraCita->estado === 'confirmada') bg-blue-100 text-blue-800
                                            @else bg-green-100 text-green-800 @endif">
                                            {{ ucfirst($otraCita->estado) }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>

                            @if($cita->paciente->citasActivas->count() > 4)
                                <div class="mt-4 text-center">
                                    <p class="text-sm text-gray-500">
                                        Y {{ $cita->paciente->citasActivas->count() - 4 }} citas más...
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Acciones adicionales -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Acciones</h3>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('citas.index') }}"
                        class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        <i class="fas fa-list mr-2"></i>
                        Ver todas las citas
                    </a>

                    <a href="{{ route('citas.create') }}"
                        class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                        <i class="fas fa-plus mr-2"></i>
                        Agendar nueva cita
                    </a>

                    @if($cita->estado !== 'cancelada' && $cita->estado !== 'completada')
                        <form method="POST" action="{{ route('citas.destroy', $cita) }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="inline-flex items-center px-3 py-2 border border-red-300 rounded-md shadow-sm text-sm font-medium text-red-700 bg-white hover:bg-red-50"
                                onclick="return confirm('¿Estás seguro de eliminar esta cita? Esta acción no se puede deshacer.')">
                                <i class="fas fa-trash mr-2"></i>
                                Eliminar cita
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
