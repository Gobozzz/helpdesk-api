<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Models\User;

final class UserHasAnyRoleAction
{
    /**
     * @param  string[]  $roles
     */
    public function handle(User $user, array $roles): bool
    {
        return in_array($user->role->value, $roles);
    }
}
