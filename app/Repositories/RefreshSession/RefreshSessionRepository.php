<?php

declare(strict_types=1);

namespace App\Repositories\RefreshSession;

use App\Models\RefreshSession;
use App\Models\User;
use Carbon\Carbon;

final class RefreshSessionRepository implements RefreshSessionRepositoryContract
{

    public function create(User $user, string $token, string $fingerprint): RefreshSession
    {
        return RefreshSession::create([
            "user_id" => $user->getKey(),
            "refresh_token" => $token,
            "fingerprint" => $fingerprint,
            "expires_at" => Carbon::now()->addMinutes(config('jwt.refresh_ttl')),
        ]);
    }

    public function getCountActiveForUser(User $user): int
    {
        return $user->refreshSessions()->active()->count();
    }

    public function deleteByToken(string $refresh_token): void
    {
        RefreshSession::query()->where('refresh_token', $refresh_token)->delete();
    }

    public function deleteAll(User $user): void
    {
        $user->refreshSessions()->delete();
    }

    public function getByRefreshToken(string $refresh_token): RefreshSession
    {
        return RefreshSession::query()
            ->where('refresh_token', $refresh_token)
            ->firstOrFail();
    }

    public function getByFingerprint(string $fingerprint): ?RefreshSession
    {
        return RefreshSession::query()
            ->where('fingerprint', $fingerprint)
            ->first();
    }

    public function deleteByFingerprint(string $fingerprint): void
    {
        RefreshSession::query()
            ->where('fingerprint', $fingerprint)
            ->delete();
    }
}
