<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\Adapters\Hash\HasherContract;
use App\DTO\Auth\LoginDTO;
use App\DTO\Auth\RegisterDTO;
use App\DTO\JWT\GeneratedTokensDTO;
use App\DTO\User\UserCreateDTO;
use App\Enums\UserRole;
use App\Models\User;
use App\Repositories\RefreshSession\RefreshSessionRepositoryContract;
use App\Repositories\User\UserRepositoryContract;
use App\Services\JWT\JWTServiceContract;
use Illuminate\Auth\AuthenticationException;

final class AuthService implements AuthServiceContract
{
    const MAX_AUTH_SESSIONS = 5;

    public function __construct(
        private readonly UserRepositoryContract $users,
        private readonly RefreshSessionRepositoryContract $refreshSessions,
        private readonly HasherContract $hasher,
        private readonly JWTServiceContract $jwt,
    ) {}

    public function register(RegisterDTO $data): void
    {
        // вынести в маппер ?
        $userCreateDto = new UserCreateDTO(
            name: $data->name,
            email: $data->email,
            password: $this->hasher->make($data->password),
            role: UserRole::USER,
        );
        $this->users->create($userCreateDto);
    }

    public function login(LoginDTO $data): GeneratedTokensDTO
    {
        $user = $this->users->getByEmail($data->email);

        if ($user === null || ! $this->checkPassword($data->password, $user->password)) {
            throw new AuthenticationException('Invalid credentials.');
        }

        $this->checkCountActiveSessions($user);

        $this->checkAlreadyFingerprintExist($data->fingerprint);

        return $this->jwt->generateTokens(user: $user, fingerprint: $data->fingerprint);
    }

    public function logout(string $refresh_token): void
    {
        $this->jwt->invalidateRefreshToken($refresh_token);
    }

    public function refresh(string $refresh_token, string $fingerprint): GeneratedTokensDTO
    {
        return $this->jwt->refreshTokens($refresh_token, $fingerprint);
    }

    private function checkCountActiveSessions(User $user): void
    {
        if ($this->refreshSessions->getCountActiveForUser($user) >= self::MAX_AUTH_SESSIONS) {
            $this->refreshSessions->deleteAll($user);
        }
    }

    private function checkAlreadyFingerprintExist(string $fingerprint): void
    {
        if ($this->refreshSessions->getByFingerprint($fingerprint)) {
            $this->refreshSessions->deleteByFingerprint($fingerprint);
        }
    }

    private function checkPassword(string $password, string $hashedPassword): bool
    {
        return $this->hasher->verify($password, $hashedPassword);
    }
}
