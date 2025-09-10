@extends('layouts.app')

@section('title', 'Lista de Pacientes - MediCore')

@section('page-title', 'Lista de Pacientes')

@section('content')
    <!-- Content -->
    <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-800">Gestión de Pacientes</h2>
            <a href="{{ route('pacientes.create') }}" class="bg-gradient-to-r from-emerald-500 to-teal-500 text-white px-4 py-2 rounded-lg hover:from-emerald-600 hover:to-teal-600 transition-all duration-200 flex items-center">
                <i class="fas fa-plus mr-2"></i>
                Nuevo Paciente
            </a>
        </div>

        <div class="overflow-x-auto rounded-lg border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Paciente</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Documento</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha Nacimiento</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Teléfono</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($pacientes as $paciente)
                        <tr class="hover:bg-gray-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 flex-shrink-0 bg-gradient-to-r from-emerald-100 to-teal-100 rounded-full flex items-center justify-center border border-emerald-200">
                                        <span class="text-emerald-800 font-medium text-sm">{{ substr($paciente->nombre, 0, 2) }}</span>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $paciente->nombre }}</div>
                                        <div class="text-sm text-gray-500">ID: PT-{{ str_pad($paciente->id, 4, '0', STR_PAD_LEFT) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $paciente->documento }}</div>
                                <div class="text-sm text-gray-500">Edad: {{ $paciente->edad }} años</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $paciente->fecha_nacimiento_formateada }}</div>
                                <div class="text-sm text-gray-500">{{ $paciente->fecha_nacimiento->diffForHumans() }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $paciente->telefono ?? 'N/A' }}</div>
                                @if($paciente->telefono)
                                    <div class="text-sm text-gray-500">
                                        <i class="fas fa-phone text-xs mr-1"></i>
                                        Contacto disponible
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Activo
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('pacientes.show', $paciente) }}"
                                       class="text-emerald-600 hover:text-emerald-900 p-2 rounded-lg hover:bg-emerald-50 transition-all duration-200"
                                       title="Ver detalles">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('pacientes.edit', $paciente) }}"
                                       class="text-blue-600 hover:text-blue-900 p-2 rounded-lg hover:bg-blue-50 transition-all duration-200"
                                       title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="{{ route('pacientes.destroy', $paciente) }}" class="inline" onsubmit="return confirm('¿Está seguro de que desea eliminar este paciente?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-red-600 hover:text-red-900 p-2 rounded-lg hover:bg-red-50 transition-all duration-200"
                                                title="Eliminar">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-user-injured text-gray-400 text-6xl mb-4"></i>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">No hay pacientes registrados</h3>
                                    <p class="text-gray-500 mb-4">Comience agregando el primer paciente al sistema.</p>
                                    <a href="{{ route('pacientes.create') }}" class="bg-gradient-to-r from-emerald-500 to-teal-500 text-white px-6 py-2 rounded-lg hover:from-emerald-600 hover:to-teal-600 transition-all duration-200">
                                        <i class="fas fa-plus mr-2"></i>
                                        Agregar Primer Paciente
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pacientes->count() > 0)
            <div class="mt-6 flex items-center justify-between">
                <div class="text-sm text-gray-700">
                    Mostrando {{ $pacientes->count() }} de {{ $pacientes->count() }} pacientes
                </div>
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-500">Ordenado por:</span>
                    <span class="bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded-full">Nombre A-Z</span>
                </div>
            </div>
        @endif
    </div>

    <!-- Estadísticas rápidas -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-gradient-to-r from-emerald-50 to-teal-50 rounded-xl p-5 border border-emerald-100">
            <div class="flex items-center">
                <div class="bg-emerald-100 p-3 rounded-lg mr-4">
                    <i class="fas fa-user-injured text-emerald-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total Pacientes</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $pacientes->count() }}</h3>
                </div>
            </div>
            <div class="mt-3 pt-3 border-t border-emerald-100 flex items-center">
                <span class="bg-emerald-100 text-emerald-800 text-xs px-2 py-1 rounded-full">
                    <i class="fas fa-arrow-up mr-1"></i>
                    Activos
                </span>
            </div>
        </div>

        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-5 border border-blue-100">
            <div class="flex items-center">
                <div class="bg-blue-100 p-3 rounded-lg mr-4">
                    <i class="fas fa-calendar-plus text-blue-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Registros Hoy</p>
                    <h3 class="text-2xl font-bold text-gray-800">{{ $pacientes->where('created_at', '>=', today())->count() }}</h3>
                </div>
            </div>
            <div class="mt-3 pt-3 border-t border-blue-100 flex items-center">
                <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
                    <i class="fas fa-plus mr-1"></i>
                    Nuevos
                </span>
            </div>
        </div>

        <div class="bg-gradient-to-r from-amber-50 to-orange-50 rounded-xl p-5 border border-amber-100">
            <div class="flex items-center">
                <div class="bg-amber-100 p-3 rounded-lg mr-4">
                    <i class="fas fa-chart-line text-amber-600 text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Promedio Edad</p>
                    <h3 class="text-2xl font-bold text-gray-800">
                        @if($pacientes->count() > 0)
                            {{ round($pacientes->avg('edad')) }}
                        @else
                            0
                        @endif
                    </h3>
                </div>
            </div>
            <div class="mt-3 pt-3 border-t border-amber-100 flex items-center">
                <span class="bg-amber-100 text-amber-800 text-xs px-2 py-1 rounded-full">
                    <i class="fas fa-users mr-1"></i>
                    Años
                </span>
            </div>
        </div>
    </div>
@endsection
