<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\HashService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;

class AuthController extends Controller
{
    public function __construct(protected UserService $userService, protected HashService $hashService)
    {
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['password'] = $this->hashService->cryptString($data['password']);
        $user = $this->userService->create($data);
        $token = $this->userService->createToken($user, 'api_token');
        $result = ['user' => $user, 'token' => $token];
        return response()->json($result, 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $credentials = $request->validated();
            $user = $this->userService->findByEmail($credentials['email']);

            if (! $user || !$this->hashService->check($credentials['password'], $user->password)) {
                return response()->json(['message' => 'Invalid credentials'], 401);
            }
            $this->userService->revokeTokens($user);
            $token = $this->userService->createToken($user, 'api_token');
            $result = ['user' => $user, 'token' => $token];
            return response()->json($result);
        } catch (\RuntimeException $e) {
            return response()->json(['message' => $e->getMessage()], 401);
        }
    }
    public function logout(Request $request): JsonResponse
    {
        try {
            $user = Auth::user();
            if (! $user) {
                return response()->json(['message' => 'User not authenticated'], 401);
            }
            $this->userService->revokeTokens($user);

            return response()->json(['message' => 'Logged out successfully']);
        } catch (\RuntimeException $e) {
            return response()->json(['message' => $e->getMessage()], 401);
        }
    }
}
