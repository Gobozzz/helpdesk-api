<?php

declare(strict_types=1);

namespace App\DTO\JWT;

final readonly class GeneratedTokensDTO
{
    public function __construct(
        public string $access,
        public string $refresh,
    )
    {

    }
}
