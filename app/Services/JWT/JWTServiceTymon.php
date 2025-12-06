<?php

declare(strict_types=1);

namespace App\Services\JWT;

use App\Adapters\Hash\HasherContract;
use App\DTO\JWT\GeneratedTokensDTO;
use App\Exceptions\InvalidFingerprintException;
use App\Models\RefreshSession;
use App\Models\User;
use App\Repositories\RefreshSession\RefreshSessionRepositoryContract;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Facades\JWTAuth;

final class JWTServiceTymon implements JWTServiceContract
{
    public function __construct(
        private readonly RefreshSessionRepositoryContract $refreshSessions,
        private readonly HasherContract $hasher,
    ) {}

    public function generateTokens(User $user, string $fingerprint): GeneratedTokensDTO
    {
        $refreshToken = $this->generateRefreshToken();
        $refreshTokenHashed = $this->hashedRefreshToken($refreshToken);

        $accessToken = $this->generateAccessToken($user);

        $this->refreshSessions->create(user: $user, token: $refreshTokenHashed, fingerprint: $fingerprint);

        return new GeneratedTokensDTO(access: $accessToken, refresh: $refreshToken);
    }

    public function invalidateRefreshToken(string $refresh_token): void
    {
        $this->refreshSessions->deleteByToken($this->hashedRefreshToken($refresh_token));
    }

    public function refreshTokens(string $refresh_token, string $fingerprint): GeneratedTokensDTO
    {
        $hashed_refresh_token = $this->hashedRefreshToken($refresh_token);
        $refreshSession = $this->refreshSessions->getByRefreshToken($hashed_refresh_token);
        $user = $refreshSession->user;

        $this->refreshSessions->deleteByToken($hashed_refresh_token);

        $this->checkRefreshSessionBeforeRefreshTokens($refreshSession, $fingerprint);

        return $this->generateTokens($user, $fingerprint);
    }

    private function checkRefreshSessionBeforeRefreshTokens(RefreshSession $refreshSession, string $fingerprint): void
    {
        if ($refreshSession->isExpired()) {
            throw new TokenExpiredException('Refresh is expired');
        }
        if ($refreshSession->fingerprint !== $fingerprint) {
            throw new InvalidFingerprintException;
        }
    }

    private function generateAccessToken(User $user): string
    {
        return JWTAuth::fromUser($user);
    }

    private function generateRefreshToken(): string
    {
        return Str::uuid()->toString();
    }

    private function hashedRefreshToken(string $token): string
    {
        return $this->hasher->sha256($token);
    }
}
