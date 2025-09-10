@extends('layouts.app')

@section('title', 'Dashboard de Admisiones')
@section('page-title', 'Dashboard de Admisiones')

@section('content')
    <div class="space-y-6">
        <!-- Estadísticas del día -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total admisiones hoy -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                                <i class="fas fa-calendar-check text-white text-sm"></i>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Total Hoy
                                </dt>
                                <dd class="text-lg font-medium text-gray-900">
                                    {{ $estadisticas['total_hoy'] }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Admitidos -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                                <i class="fas fa-user-check text-white text-sm"></i>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Admitidos
                                </dt>
                                <dd class="text-lg font-medium text-green-600">
                                    {{ $estadisticas['admitidos_hoy'] }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- No asistieron -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-red-500 rounded-md flex items-center justify-center">
                                <i class="fas fa-user-times text-white text-sm"></i>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    No Asistieron
                                </dt>
                                <dd class="text-lg font-medium text-red-600">
                                    {{ $estadisticas['no_asistieron_hoy'] }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pendientes -->
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                                <i class="fas fa-clock text-white text-sm"></i>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Pendientes
                                </dt>
                                <dd class="text-lg font-medium text-yellow-600">
                                    {{ $estadisticas['citas_pendientes_admision'] }}
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Acciones rápidas -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Acciones Rápidas</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <a href="{{ route('admisiones.index') }}"
                        class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors">
                        <div class="flex-shrink-0">
                            <i class="fas fa-list text-blue-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-sm font-medium text-blue-900">Ver Todas las Admisiones</h4>
                            <p class="text-xs text-blue-600">Gestionar admisiones completas</p>
                        </div>
                    </a>

                    <a href="{{ route('admisiones.create') }}"
                        class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors">
                        <div class="flex-shrink-0">
                            <i class="fas fa-plus text-green-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-sm font-medium text-green-900">Nueva Admisión</h4>
                            <p class="text-xs text-green-600">Registrar nueva admisión</p>
                        </div>
                    </a>

                    <a href="{{ route('citas.index') }}"
                        class="flex items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors">
                        <div class="flex-shrink-0">
                            <i class="fas fa-calendar text-purple-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-sm font-medium text-purple-900">Ver Citas</h4>
                            <p class="text-xs text-purple-600">Gestionar citas médicas</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Citas pendientes de admisión -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">
                        Citas Pendientes de Admisión
                        <span class="ml-2 inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                            {{ $citasPendientes->count() }}
                        </span>
                    </h3>
                </div>
                <div class="max-h-96 overflow-y-auto">
                    @if($citasPendientes->count() > 0)
                        <ul class="divide-y divide-gray-200">
                            @foreach($citasPendientes as $cita)
                                <li class="px-6 py-4 hover:bg-gray-50">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-full bg-emerald-100 flex items-center justify-center">
                                                    <i class="fas fa-user text-emerald-600"></i>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $cita->paciente->nombre }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $cita->fecha->format('d/m/Y') }} - {{ substr($cita->hora, 0, 5) }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ route('admisiones.create', ['cita_id' => $cita->id]) }}"
                                                class="inline-flex items-center px-3 py-1 border border-transparent text-xs font-medium rounded-full text-white bg-emerald-600 hover:bg-emerald-700">
                                                <i class="fas fa-plus mr-1"></i>
                                                Crear Admisión
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="px-6 py-8 text-center">
                            <div class="mx-auto h-12 w-12 text-gray-400">
                                <i class="fas fa-check-circle text-4xl"></i>
                            </div>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No hay citas pendientes</h3>
                            <p class="mt-1 text-sm text-gray-500">Todas las citas confirmadas ya tienen admisión</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Admisiones recientes -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">
                        Admisiones de Hoy
                        <span class="ml-2 inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                            {{ $admisionesHoy->count() }}
                        </span>
                    </h3>
                </div>
                <div class="max-h-96 overflow-y-auto">
                    @if($admisionesHoy->count() > 0)
                        <ul class="divide-y divide-gray-200">
                            @foreach($admisionesHoy as $admision)
                                <li class="px-6 py-4 hover:bg-gray-50">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                    <i class="fas fa-user text-blue-600"></i>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $admision->cita->paciente->nombre }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $admision->cita->fecha->format('d/m/Y') }} - {{ substr($admision->cita->hora, 0, 5) }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex items-center space-x-2">
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
                                            <a href="{{ route('admisiones.show', $admision) }}"
                                                class="text-emerald-600 hover:text-emerald-900">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="px-6 py-8 text-center">
                            <div class="mx-auto h-12 w-12 text-gray-400">
                                <i class="fas fa-calendar-times text-4xl"></i>
                            </div>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">No hay admisiones hoy</h3>
                            <p class="mt-1 text-sm text-gray-500">Aún no se han registrado admisiones para hoy</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
