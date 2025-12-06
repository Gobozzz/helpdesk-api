<?php

declare(strict_types=1);

namespace App\Services\Ticket;

use App\DTO\Ticket\TicketChangeStatusDTO;
use App\DTO\Ticket\TicketCommentDTO;
use App\DTO\Ticket\TicketCreateDTO;
use App\Models\Ticket;
use App\Models\User;

interface TicketServiceContract
{
    public function create(TicketCreateDTO $data): Ticket;

    public function assign(Ticket $ticket, User $user): Ticket;

    public function setStatus(Ticket $ticket, TicketChangeStatusDTO $data): Ticket;

    public function comment(Ticket $ticket, TicketCommentDTO $data): Ticket;
}
