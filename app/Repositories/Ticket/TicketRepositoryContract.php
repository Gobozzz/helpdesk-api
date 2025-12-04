<?php

declare(strict_types=1);

namespace App\Repositories\Ticket;

use App\DTO\Ticket\TicketCreateDTO;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

interface TicketRepositoryContract
{
    public function create(TicketCreateDTO $data, User $user): Ticket;

    public function getAll(): LengthAwarePaginator;

    public function getAllByUser(User $user): LengthAwarePaginator;
}
