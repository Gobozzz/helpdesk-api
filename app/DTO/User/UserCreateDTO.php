<?php

declare(strict_types=1);

namespace App\DTO\User;

use App\Enums\UserRole;

final readonly class UserCreateDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
        public UserRole $role,
    )
    {
    }

}
