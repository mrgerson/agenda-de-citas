<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Protected Routes (will be used for future modules)
Route::middleware('auth')->group(function () {
    // Placeholder for pacientes module
    Route::get('/pacientes', function () {
        return view('welcome'); // Temporary placeholder
    })->name('pacientes.index');
});
