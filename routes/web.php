<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PacienteController;
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
});
