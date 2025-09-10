<?php

namespace App\Repositories\Contracts;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface UserRepositoryInterface
{
    // Métodos CRUD básicos
    public function find(int $id): ?User;
    public function findOrFail(int $id): User;
    public function all(): Collection;
    public function create(array $data): User;
    public function update(int $id, array $data): bool;
    public function delete(int $id): bool;

    // Métodos específicos de Usuario
    public function findByUsername(string $username): ?User;
    public function findByEmail(string $email): ?User;
    public function findByUsernameOrEmail(string $login): ?User;
    public function existsByUsername(string $username): bool;
    public function existsByEmail(string $email): bool;
}
