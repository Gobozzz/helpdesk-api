<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\UserRole;
use App\Models\Ticket;
use App\Models\User;

final class TicketPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->role === UserRole::ADMIN || $user->role === UserRole::AGENT;
    }


    public function setStatus(User $user, Ticket $ticket): bool
    {
        return $user->role === UserRole::ADMIN ||
            ($user->role === UserRole::AGENT && $ticket->assigned_user_id === $user->getKey());
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Ticket $ticket): bool
    {
        return $user->role === UserRole::ADMIN || $user->role === UserRole::AGENT ||
            $ticket->user_id === $user->getKey();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role === UserRole::USER;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Ticket $ticket): bool
    {
        return $ticket->user_id === $user->getKey();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Ticket $ticket): bool
    {
        return $user->role === UserRole::ADMIN || $user->role === UserRole::AGENT ||
            $ticket->user_id === $user->getKey();
    }

}
