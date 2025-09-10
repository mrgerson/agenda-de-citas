<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserRepositoryInterface
{
    protected User $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    // Métodos CRUD básicos
    public function find(int $id): ?User
    {
        return $this->model->find($id);
    }

    public function findOrFail(int $id): User
    {
        return $this->model->findOrFail($id);
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function create(array $data): User
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): bool
    {
        $user = $this->findOrFail($id);
        return $user->update($data);
    }

    public function delete(int $id): bool
    {
        $user = $this->findOrFail($id);
        return $user->delete();
    }

    // Métodos específicos de Usuario
    public function findByUsername(string $username): ?User
    {
        return $this->model->where('username', $username)->first();
    }

    public function findByEmail(string $email): ?User
    {
        return $this->model->where('email', $email)->first();
    }

    public function findByUsernameOrEmail(string $login): ?User
    {
        return $this->model
            ->where('username', $login)
            ->orWhere('email', $login)
            ->first();
    }

    public function existsByUsername(string $username): bool
    {
        return $this->model->where('username', $username)->exists();
    }

    public function existsByEmail(string $email): bool
    {
        return $this->model->where('email', $email)->exists();
    }
}
