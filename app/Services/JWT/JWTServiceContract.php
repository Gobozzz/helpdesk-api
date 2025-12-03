<?php

namespace App\Services\JWT;

use App\DTO\JWT\GeneratedTokensDTO;
use App\Models\User;

interface JWTServiceContract
{

    public function generateTokens(User $user, string $fingerprint): GeneratedTokensDTO;

    public function invalidateRefreshToken(string $refresh_token): void;

    public function refreshTokens(string $refresh_token, string $fingerprint): GeneratedTokensDTO;

}
