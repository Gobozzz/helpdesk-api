<?php

declare(strict_types=1);

namespace App\Services\Ticket;

use App\DTO\Ticket\TicketCreateDTO;
use App\Models\Ticket;
use App\Models\User;
use App\Repositories\Ticket\TicketRepositoryContract;

final class TicketService implements TicketServiceContract
{

    public function __construct(
        private readonly TicketRepositoryContract $tickets,
    )
    {
    }

    public function create(TicketCreateDTO $data, User $user): Ticket
    {
        return $this->tickets->create($data, $user);
    }

}
