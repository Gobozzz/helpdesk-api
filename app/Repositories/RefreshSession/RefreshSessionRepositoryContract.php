<?php

declare(strict_types=1);

namespace App\Repositories\RefreshSession;

use App\Models\RefreshSession;
use App\Models\User;

interface RefreshSessionRepositoryContract
{
    public function create(User $user, string $token, string $fingerprint): RefreshSession;

    public function getByRefreshToken(string $refresh_token): RefreshSession;

    public function getByFingerprint(string $fingerprint): ?RefreshSession;

    public function getCountActiveForUser(User $user): int;

    public function deleteByToken(string $refresh_token);

    public function deleteAll(User $user): void;

    public function deleteByFingerprint(string $fingerprint): void;
}
