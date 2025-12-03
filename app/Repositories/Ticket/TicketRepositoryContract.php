<?php

declare(strict_types=1);

namespace App\Repositories\Ticket;

use App\DTO\Ticket\TicketCreateDTO;
use App\Models\Ticket;
use App\Models\User;

interface TicketRepositoryContract
{
    public function create(TicketCreateDTO $data, User $user): Ticket;
}
