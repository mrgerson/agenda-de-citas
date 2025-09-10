@extends('layouts.app')

@section('title', 'Gestión de Admisiones')
@section('page-title', 'Gestión de Admisiones')

@section('content')
    <div class="space-y-6">
        <!-- Header con acciones -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
            <div>
                <p class="text-sm text-gray-600">Administra las admisiones de pacientes del sistema</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admisiones.dashboard') }}"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition duration-150 ease-in-out">
                    <i class="fas fa-chart-bar mr-2"></i>
                    Dashboard
                </a>
                <a href="{{ route('admisiones.create') }}"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition duration-150 ease-in-out">
                    <i class="fas fa-plus mr-2"></i>
                    Nueva Admisión
                </a>
            </div>
        </div>

        <!-- Filtros y buscador -->
        <div class="bg-white shadow rounded-lg">
            <div class="p-6">
                <form method="GET" action="{{ route('admisiones.index') }}" class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" name="search" value="{{ $search }}"
                                placeholder="Buscar por paciente, notas o estado..."
                                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500">
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <select name="estado"
                            class="block px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="">Todos los estados</option>
                            <option value="pendiente" {{ $estado == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="admitido" {{ $estado == 'admitido' ? 'selected' : '' }}>Admitido</option>
                            <option value="no_asistio" {{ $estado == 'no_asistio' ? 'selected' : '' }}>No Asistió</option>
                        </select>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                            <i class="fas fa-search mr-2"></i>
                            Buscar
                        </button>
                        @if($search || $estado)
                            <a href="{{ route('admisiones.index') }}"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                                <i class="fas fa-times mr-2"></i>
                                Limpiar
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Estadísticas rápidas -->
        @if(isset($estadisticas))
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-calendar-check text-blue-500 text-xl"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Hoy</dt>
                                    <dd class="text-lg font-medium text-gray-900">{{ $estadisticas['total_hoy'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-user-check text-green-500 text-xl"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Admitidos</dt>
                                    <dd class="text-lg font-medium text-green-600">{{ $estadisticas['admitidos_hoy'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-user-times text-red-500 text-xl"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">No Asistieron</dt>
                                    <dd class="text-lg font-medium text-red-600">{{ $estadisticas['no_asistieron_hoy'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <i class="fas fa-clock text-yellow-500 text-xl"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">Pendientes</dt>
                                    <dd class="text-lg font-medium text-yellow-600">{{ $estadisticas['citas_pendientes_admision'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Tabla de admisiones -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">
                    Lista de Admisiones
                    <span class="text-sm font-normal text-gray-500">
                        ({{ $admisiones->total() }} {{ $admisiones->total() == 1 ? 'admisión' : 'admisiones' }})
                    </span>
                </h3>
            </div>

            @if($admisiones->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Paciente
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Cita
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Estado
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Fecha Admisión
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($admisiones as $admision)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-full bg-emerald-100 flex items-center justify-center">
                                                    <i class="fas fa-user text-emerald-600"></i>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $admision->cita->paciente->nombre }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $admision->cita->paciente->documento }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            <i class="fas fa-calendar-alt mr-1 text-gray-400"></i>
                                            {{ $admision->cita->fecha->format('d/m/Y') }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            <i class="fas fa-clock mr-1 text-gray-400"></i>
                                            {{ substr($admision->cita->hora, 0, 5) }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
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
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        @if($admision->fecha_admision)
                                            {{ $admision->fecha_admision->format('d/m/Y H:i') }}
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-2">
                                            <!-- Ver -->
                                            <a href="{{ route('admisiones.show', $admision) }}"
                                                class="text-emerald-600 hover:text-emerald-900 p-1 rounded transition-colors"
                                                title="Ver detalles">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <!-- Acciones según estado -->
                                            @if($admision->estado === 'pendiente')
                                                <!-- Marcar como admitido -->
                                                <form method="POST" action="{{ route('admisiones.marcar-admitido', $admision) }}" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                        class="text-green-600 hover:text-green-900 p-1 rounded transition-colors"
                                                        title="Marcar como admitido"
                                                        onclick="return confirm('¿Marcar este paciente como admitido?')">
                                                        <i class="fas fa-user-check"></i>
                                                    </button>
                                                </form>

                                                <!-- Marcar como no asistió -->
                                                <form method="POST" action="{{ route('admisiones.marcar-no-asistio', $admision) }}" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                        class="text-red-600 hover:text-red-900 p-1 rounded transition-colors"
                                                        title="Marcar como no asistió"
                                                        onclick="return confirm('¿Marcar que este paciente no asistió?')">
                                                        <i class="fas fa-user-times"></i>
                                                    </button>
                                                </form>

                                                <!-- Editar -->
                                                <a href="{{ route('admisiones.edit', $admision) }}"
                                                    class="text-blue-600 hover:text-blue-900 p-1 rounded transition-colors"
                                                    title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endif

                                            <!-- Eliminar -->
                                            <form method="POST" action="{{ route('admisiones.destroy', $admision) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-900 p-1 rounded transition-colors"
                                                    title="Eliminar"
                                                    onclick="return confirm('¿Estás seguro de eliminar esta admisión? Esta acción no se puede deshacer.')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $admisiones->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <div class="mx-auto h-12 w-12 text-gray-400">
                        <i class="fas fa-clipboard-list text-4xl"></i>
                    </div>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No hay admisiones</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        @if($search || $estado)
                            No se encontraron admisiones que coincidan con los filtros aplicados.
                        @else
                            Comienza registrando una nueva admisión.
                        @endif
                    </p>
                    <div class="mt-6">
                        @if($search || $estado)
                            <a href="{{ route('admisiones.index') }}"
                                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Ver todas las admisiones
                            </a>
                        @else
                            <a href="{{ route('admisiones.create') }}"
                                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                                <i class="fas fa-plus mr-2"></i>
                                Registrar primera admisión
                            </a>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <!-- Citas pendientes de admisión -->
        @if(isset($citasPendientes) && $citasPendientes->count() > 0)
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">
                        Citas Pendientes de Admisión
                        <span class="ml-2 inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                            {{ $citasPendientes->count() }}
                        </span>
                    </h3>
                </div>
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($citasPendientes->take(6) as $cita)
                            <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-900">{{ $cita->paciente->nombre }}</h4>
                                        <p class="text-xs text-gray-500">{{ $cita->fecha->format('d/m/Y') }} - {{ substr($cita->hora, 0, 5) }}</p>
                                    </div>
                                    <a href="{{ route('admisiones.create', ['cita_id' => $cita->id]) }}"
                                        class="inline-flex items-center px-2 py-1 border border-transparent text-xs font-medium rounded-full text-white bg-emerald-600 hover:bg-emerald-700">
                                        <i class="fas fa-plus mr-1"></i>
                                        Crear
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if($citasPendientes->count() > 6)
                        <div class="mt-4 text-center">
                            <p class="text-sm text-gray-500">Y {{ $citasPendientes->count() - 6 }} citas más...</p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
@endsection
