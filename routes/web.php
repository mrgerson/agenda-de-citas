<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

// Protected Routes (will be used for future modules)
Route::middleware('auth')->group(function () {
    // Placeholder for pacientes module
    Route::get('/pacientes', function () {
        return view('welcome'); // Temporary placeholder
    })->name('pacientes.index');
});
