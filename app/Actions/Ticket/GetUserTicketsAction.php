<?php

declare(strict_types=1);

namespace App\Actions\Ticket;

use App\Models\Ticket;
use App\Models\User;
use App\Repositories\Ticket\TicketRepositoryContract;

final class GetUserTicketsAction
{
    public function __construct(
        private readonly TicketRepositoryContract $tickets,
    )
    {
    }

    public function handle(User $user)
    {
        if ($user->can('viewAny', Ticket::class)) {
            $tickets = $this->tickets->getAll();
        } else {
            $tickets = $this->tickets->getAllByUser($user);
        }

        return $tickets;
    }

}
