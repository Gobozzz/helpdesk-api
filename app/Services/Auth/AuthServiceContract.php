<?php

declare(strict_types=1);

namespace App\Services\Auth;

use App\DTO\Auth\LoginDTO;
use App\DTO\Auth\RegisterDTO;
use App\DTO\JWT\GeneratedTokensDTO;

interface AuthServiceContract
{
    public function register(RegisterDTO $data): void;

    public function login(LoginDTO $data): GeneratedTokensDTO;

    public function logout(string $refresh_token): void;

    public function refresh(string $refresh_token, string $fingerprint): GeneratedTokensDTO;
}
