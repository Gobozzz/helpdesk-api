<?php

declare(strict_types=1);

namespace App\Services\Ticket;

use App\DTO\Ticket\TicketChangeStatusDTO;
use App\DTO\Ticket\TicketCreateDTO;
use App\Enums\TicketStatus;
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

    public function create(TicketCreateDTO $data): Ticket
    {
        return $this->tickets->create($data);
    }

    public function assign(Ticket $ticket, User $user): Ticket
    {
        return $this->tickets->updateAssignId($ticket, $user->getKey());
    }

    public function setStatus(Ticket $ticket, TicketChangeStatusDTO $data): Ticket
    {
        return $this->tickets->setStatus($ticket, $data);
    }

}
