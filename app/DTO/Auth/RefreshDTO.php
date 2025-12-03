<?php

declare(strict_types=1);

namespace App\DTO\Auth;

final readonly class RefreshDTO
{
    public function __construct(
        public string $refresh_token,
        public string $fingerprint,
    )
    {
    }
}
