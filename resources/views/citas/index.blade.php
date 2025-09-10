@extends('layouts.app')

@section('title', 'Gestión de Citas')
@section('page-title', 'Gestión de Citas')

@section('content')
    <div class="space-y-6">
        <!-- Header con acciones -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
            <div>
                <p class="text-sm text-gray-600">Administra las citas médicas del sistema</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('citas.create') }}"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition duration-150 ease-in-out">
                    <i class="fas fa-plus mr-2"></i>
                    Agendar Cita
                </a>
            </div>
        </div>

        <!-- Buscador -->
        <div class="bg-white shadow rounded-lg">
            <div class="p-6">
                <form method="GET" action="{{ route('citas.index') }}" class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" name="search" value="{{ $search }}"
                                placeholder="Buscar por paciente, motivo o estado..."
                                class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500">
                        </div>
                    </div>
                    <div class="flex space-x-3">
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                            <i class="fas fa-search mr-2"></i>
                            Buscar
                        </button>
                        @if($search)
                            <a href="{{ route('citas.index') }}"
                                class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                                <i class="fas fa-times mr-2"></i>
                                Limpiar
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabla de citas -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">
                    Lista de Citas
                    <span class="text-sm font-normal text-gray-500">
                        ({{ $citas->total() }} {{ $citas->total() == 1 ? 'cita' : 'citas' }})
                    </span>
                </h3>
            </div>

            @if($citas->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Paciente
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Fecha y Hora
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Motivo
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Estado
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($citas as $cita)
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
                                                    {{ $cita->paciente->nombre }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $cita->paciente->documento }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            <i class="fas fa-calendar-alt mr-1 text-gray-400"></i>
                                            {{ $cita->fecha->format('d/m/Y') }}
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            <i class="fas fa-clock mr-1 text-gray-400"></i>
                                            {{ $cita->hora->format('H:i') }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900 max-w-xs truncate" title="{{ $cita->motivo }}">
                                            {{ Str::limit($cita->motivo, 50) }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @php
                                            $estadoClasses = [
                                                'programada' => 'bg-yellow-100 text-yellow-800',
                                                'confirmada' => 'bg-blue-100 text-blue-800',
                                                'cancelada' => 'bg-red-100 text-red-800',
                                                'completada' => 'bg-green-100 text-green-800'
                                            ];
                                        @endphp
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $estadoClasses[$cita->estado] }}">
                                            {{ ucfirst($cita->estado) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex items-center justify-end space-x-2">
                                            <!-- Ver -->
                                            <a href="{{ route('citas.show', $cita) }}"
                                                class="text-emerald-600 hover:text-emerald-900 p-1 rounded transition-colors"
                                                title="Ver detalles">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <!-- Editar -->
                                            @if($cita->estado !== 'completada' && $cita->estado !== 'cancelada')
                                                <a href="{{ route('citas.edit', $cita) }}"
                                                    class="text-blue-600 hover:text-blue-900 p-1 rounded transition-colors"
                                                    title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endif

                                            <!-- Acciones de estado -->
                                            @if($cita->estado === 'programada')
                                                <form method="POST" action="{{ route('citas.confirmar', $cita) }}" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                        class="text-blue-600 hover:text-blue-900 p-1 rounded transition-colors"
                                                        title="Confirmar cita"
                                                        onclick="return confirm('¿Confirmar esta cita?')">
                                                        <i class="fas fa-check-circle"></i>
                                                    </button>
                                                </form>
                                            @elseif($cita->estado === 'confirmada')
                                                <form method="POST" action="{{ route('citas.completar', $cita) }}" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                        class="text-green-600 hover:text-green-900 p-1 rounded transition-colors"
                                                        title="Marcar como completada"
                                                        onclick="return confirm('¿Marcar esta cita como completada?')">
                                                        <i class="fas fa-check-double"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            <!-- Cancelar -->
                                            @if($cita->estado !== 'cancelada' && $cita->estado !== 'completada')
                                                <form method="POST" action="{{ route('citas.cancelar', $cita) }}" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                        class="text-red-600 hover:text-red-900 p-1 rounded transition-colors"
                                                        title="Cancelar cita"
                                                        onclick="return confirm('¿Cancelar esta cita?')">
                                                        <i class="fas fa-times-circle"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            <!-- Eliminar -->
                                            <form method="POST" action="{{ route('citas.destroy', $cita) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="text-red-600 hover:text-red-900 p-1 rounded transition-colors"
                                                    title="Eliminar"
                                                    onclick="return confirm('¿Estás seguro de eliminar esta cita? Esta acción no se puede deshacer.')">
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
                    {{ $citas->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <div class="mx-auto h-12 w-12 text-gray-400">
                        <i class="fas fa-calendar-times text-4xl"></i>
                    </div>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No hay citas</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        @if($search)
                            No se encontraron citas que coincidan con "{{ $search }}"
                        @else
                            Comienza agendando una nueva cita.
                        @endif
                    </p>
                    <div class="mt-6">
                        @if($search)
                            <a href="{{ route('citas.index') }}"
                                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Ver todas las citas
                            </a>
                        @else
                            <a href="{{ route('citas.create') }}"
                                class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                                <i class="fas fa-plus mr-2"></i>
                                Agendar primera cita
                            </a>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
