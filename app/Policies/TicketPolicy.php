<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Ticket;
use App\Models\User;

final class TicketPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->role === UserRole::ADMIN || $user->role === UserRole::AGENT;
    }

    public function setStatus(User $user, Ticket $ticket): bool
    {
        return $user->role === UserRole::ADMIN || $ticket->assigned_user_id === $user->getKey();
    }

    public function comment(User $user, Ticket $ticket): bool
    {
        return $user->role === UserRole::ADMIN ||
            $ticket->assigned_user_id === $user->getKey() ||
            $ticket->user_id === $user->getKey();
    }

    public function view(User $user, Ticket $ticket): bool
    {
        return $user->role === UserRole::ADMIN || $user->role === UserRole::AGENT ||
            $ticket->user_id === $user->getKey();
    }
}
