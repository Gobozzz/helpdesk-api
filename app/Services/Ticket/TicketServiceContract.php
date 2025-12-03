<?php

declare(strict_types=1);

namespace App\Services\Ticket;

use App\DTO\Ticket\TicketCreateDTO;
use App\Models\Ticket;
use App\Models\User;

interface TicketServiceContract
{
    public function create(TicketCreateDTO $data, User $user): Ticket;
}
