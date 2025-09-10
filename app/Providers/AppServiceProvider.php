<?php

namespace App\Providers;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\Contracts\PacienteRepositoryInterface;
use App\Repositories\Eloquent\PacienteRepository;
use App\Repositories\Contracts\CitaRepositoryInterface;
use App\Repositories\Eloquent\CitaRepository;
use App\Repositories\Contracts\AdmisionRepositoryInterface;
use App\Repositories\Eloquent\AdmisionRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register Repository Bindings
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(PacienteRepositoryInterface::class, PacienteRepository::class);
        $this->app->bind(CitaRepositoryInterface::class, CitaRepository::class);
        $this->app->bind(AdmisionRepositoryInterface::class, AdmisionRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
