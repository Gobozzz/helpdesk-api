<?php

declare(strict_types=1);

namespace App\Repositories\User;

use App\DTO\User\UserCreateDTO;
use App\Models\User;

interface UserRepositoryContract
{
    public function create(UserCreateDTO $data): User;

    public function getByEmail(string $email): ?User;
}
