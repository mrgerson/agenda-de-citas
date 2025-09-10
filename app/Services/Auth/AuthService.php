<?php

namespace App\Services\Auth;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Intentar autenticar un usuario
     */
    public function attempt(string $login, string $password): bool
    {
        $user = $this->userRepository->findByUsernameOrEmail($login);

        if (!$user) {
            return false;
        }

        if (!Hash::check($password, $user->password)) {
            return false;
        }

        Auth::login($user);
        return true;
    }

    /**
     * Obtener el usuario autenticado
     */
    public function user(): ?User
    {
        return Auth::user();
    }

    /**
     * Verificar si hay un usuario autenticado
     */
    public function check(): bool
    {
        return Auth::check();
    }

    /**
     * Cerrar sesión del usuario
     */
    public function logout(): void
    {
        Auth::logout();
    }

    /**
     * Verificar credenciales sin autenticar
     */
    public function validateCredentials(string $login, string $password): bool
    {
        $user = $this->userRepository->findByUsernameOrEmail($login);

        if (!$user) {
            return false;
        }

        return Hash::check($password, $user->password);
    }

    /**
     * Buscar usuario por login (username o email)
     */
    public function findUserByLogin(string $login): ?User
    {
        return $this->userRepository->findByUsernameOrEmail($login);
    }
}
