<?php

declare(strict_types=1);

namespace App\Services\Ticket;

use App\DTO\Ticket\TicketChangeStatusDTO;
use App\DTO\Ticket\TicketCommentDTO;
use App\DTO\Ticket\TicketCreateDTO;
use App\Enums\TicketEventType;
use App\Jobs\SendTicketEmailJob;
use App\Models\Ticket;
use App\Models\User;
use App\Repositories\Ticket\TicketRepositoryContract;

final class TicketService implements TicketServiceContract
{
    public function __construct(
        private readonly TicketRepositoryContract $tickets,
    ) {}

    public function create(TicketCreateDTO $data): Ticket
    {
        $ticket = $this->tickets->create($data);
        SendTicketEmailJob::dispatch($ticket->getKey(), TicketEventType::CREATED);

        return $ticket;
    }

    public function assign(Ticket $ticket, User $user): Ticket
    {
        $ticket = $this->tickets->updateAssignId($ticket, $user->getKey());
        SendTicketEmailJob::dispatch($ticket->getKey(), TicketEventType::ASSIGNED);

        return $ticket;
    }

    public function setStatus(Ticket $ticket, TicketChangeStatusDTO $data): Ticket
    {
        $ticket = $this->tickets->setStatus($ticket, $data);
        SendTicketEmailJob::dispatch($ticket->getKey(), TicketEventType::STATUS_CHANGED);

        return $ticket;
    }

    public function comment(Ticket $ticket, TicketCommentDTO $data): Ticket
    {
        $ticket = $this->tickets->comment($ticket, $data);
        SendTicketEmailJob::dispatch($ticket->getKey(), TicketEventType::COMMENT);

        return $ticket;
    }
}
