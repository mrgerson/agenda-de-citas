<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\CitaController;
use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.post');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

// Protected Routes
Route::middleware('auth')->group(function () {
    // Pacientes CRUD
    Route::resource('pacientes', PacienteController::class);

    // Citas CRUD
    Route::resource('citas', CitaController::class);

    // Rutas adicionales para cambios de estado de citas
    Route::patch('citas/{cita}/confirmar', [CitaController::class, 'confirmar'])->name('citas.confirmar');
    Route::patch('citas/{cita}/cancelar', [CitaController::class, 'cancelar'])->name('citas.cancelar');
    Route::patch('citas/{cita}/completar', [CitaController::class, 'completar'])->name('citas.completar');
});
