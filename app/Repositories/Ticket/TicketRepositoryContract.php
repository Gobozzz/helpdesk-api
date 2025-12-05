<?php

declare(strict_types=1);

namespace App\Repositories\Ticket;

use App\DTO\Ticket\TicketChangeStatusDTO;
use App\DTO\Ticket\TicketCommentDTO;
use App\DTO\Ticket\TicketCreateDTO;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

interface TicketRepositoryContract
{
    public function create(TicketCreateDTO $data): Ticket;

    public function getAll(): LengthAwarePaginator;

    public function getById(string $id): Ticket;

    public function getAllByUser(User $user): LengthAwarePaginator;

    public function updateAssignId(Ticket $ticket, string|int $assignId): Ticket;

    public function setStatus(Ticket $ticket, TicketChangeStatusDTO $data): Ticket;

    public function comment(Ticket $ticket, TicketCommentDTO $data): Ticket;
}
