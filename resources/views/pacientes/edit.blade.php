@extends('layouts.app')

@section('title', 'Editar Paciente')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center space-x-4">
        <a href="{{ route('pacientes.index') }}"
           class="text-gray-500 hover:text-gray-700">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <h1 class="text-2xl font-semibold text-gray-900">Editar Paciente</h1>
    </div>

    <!-- Form -->
    <div class="bg-white shadow rounded-lg">
        <form method="POST" action="{{ route('pacientes.update', $paciente) }}" class="space-y-6 p-6">
            @csrf
            @method('PUT')

            <!-- Nombre -->
            <div>
                <label for="nombre" class="block text-sm font-medium text-gray-700">
                    Nombre Completo *
                </label>
                <div class="mt-1">
                    <input type="text"
                           id="nombre"
                           name="nombre"
                           value="{{ old('nombre', $paciente->nombre) }}"
                           required
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('nombre') border-red-300 @enderror">
                </div>
                @error('nombre')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Documento -->
            <div>
                <label for="documento" class="block text-sm font-medium text-gray-700">
                    Documento *
                </label>
                <div class="mt-1">
                    <input type="text"
                           id="documento"
                           name="documento"
                           value="{{ old('documento', $paciente->documento) }}"
                           required
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('documento') border-red-300 @enderror">
                </div>
                @error('documento')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Fecha de Nacimiento -->
            <div>
                <label for="fecha_nacimiento" class="block text-sm font-medium text-gray-700">
                    Fecha de Nacimiento *
                </label>
                <div class="mt-1">
                    <input type="date"
                           id="fecha_nacimiento"
                           name="fecha_nacimiento"
                           value="{{ old('fecha_nacimiento', $paciente->fecha_nacimiento->format('Y-m-d')) }}"
                           required
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('fecha_nacimiento') border-red-300 @enderror">
                </div>
                @error('fecha_nacimiento')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Teléfono -->
            <div>
                <label for="telefono" class="block text-sm font-medium text-gray-700">
                    Teléfono *
                </label>
                <div class="mt-1">
                    <input type="text"
                           id="telefono"
                           name="telefono"
                           value="{{ old('telefono', $paciente->telefono) }}"
                           required
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('telefono') border-red-300 @enderror">
                </div>
                @error('telefono')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex justify-end space-x-3 pt-6 border-t">
                <a href="{{ route('pacientes.index') }}"
                   class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500">
                    Cancelar
                </a>
                <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Actualizar Paciente
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
