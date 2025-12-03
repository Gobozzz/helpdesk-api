<?php

declare(strict_types=1);

namespace App\Repositories\User;

use App\DTO\User\UserCreateDTO;
use App\Enums\UserRole;
use App\Models\User;

final class UserRepository implements UserRepositoryContract
{

    public function create(UserCreateDTO $data): User
    {
        return User::create([
            'name' => $data->name,
            'email' => $data->email,
            'password' => $data->password,
            'role' => UserRole::default(),
        ]);
    }

    public function getByEmail(string $email): ?User
    {
        return User::query()->where('email', $email)->first();
    }

}
