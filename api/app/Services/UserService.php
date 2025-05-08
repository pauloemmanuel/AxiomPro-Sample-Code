<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(protected UserRepositoryInterface $userRepository)
    {
    }
    public function create(array $data): User
    {
        return $this->userRepository->create($data);
    }
    public function createToken(User $user, string $name): string
    {
        return $this->userRepository->createToken($user, $name);
    }
    public function findByEmail(string $email): ?User
    {
        return $this->userRepository->findByEmail($email);
    }
    public function revokeTokens(User $user): void
    {
        $this->userRepository->revokeTokens($user);
    }
}
