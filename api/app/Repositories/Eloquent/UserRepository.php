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

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function find(int $id): ?User
    {
        return $this->model->find($id);
    }

    public function create(array $data): User
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): bool
    {
        $customer = $this->model->findOrFail($id);
        return $customer->update($data);
    }

    public function delete(int $id): bool
    {
        $customer = $this->model->findOrFail($id);
        return $customer->delete();
    }
    public function findByEmail(string $email): ?User
    {
        return $this->model->where('email', $email)->first();
    }

    public function save(User $user): User
    {
        $user->save();
        return $user;
    }

    public function revokeTokens(User $user): void
    {
        $user->tokens()->delete();
    }

    public function createToken(User $user, string $name): string
    {
        return $user->createToken($name)->plainTextToken;
    }
}
