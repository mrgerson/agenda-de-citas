<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\Auth\AuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LoginController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
        $this->middleware('guest')->except('logout');
    }

    /**
     * Mostrar el formulario de login
     */
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    /**
     * Procesar el login
     */
    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->validated();

        if ($this->authService->attempt($credentials['login'], $credentials['password'])) {
            $request->session()->regenerate();

            return redirect()
                ->intended(route('pacientes.index'))
                ->with('success', '¡Bienvenido! Has iniciado sesión correctamente.');
        }

        return back()
            ->withErrors(['login' => 'Las credenciales proporcionadas no coinciden con nuestros registros.'])
            ->withInput($request->only('login'));
    }

    /**
     * Cerrar sesión
     */
    public function logout(): RedirectResponse
    {
        $this->authService->logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('success', 'Has cerrado sesión correctamente.');
    }
}
