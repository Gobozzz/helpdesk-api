<?php

declare(strict_types=1);

namespace App\Repositories\Ticket;

use App\DTO\Ticket\TicketCreateDTO;
use App\Enums\TicketEventType;
use App\Enums\TicketStatus;
use App\Filters\Groups\TicketGetFiltersGroup;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

final class TicketRepository implements TicketRepositoryContract
{
    const PAGINATE_GET_ALL = 10;

    public function getAll(): LengthAwarePaginator
    {
        return Ticket::query()
            ->filtered(TicketGetFiltersGroup::filters())
            ->paginate(self::PAGINATE_GET_ALL);
    }

    public function getAllByUser(User $user): LengthAwarePaginator
    {
        return $user
            ->tickets()
            ->filtered(TicketGetFiltersGroup::filters())
            ->paginate(self::PAGINATE_GET_ALL);
    }

    public function create(TicketCreateDTO $data, User $user): Ticket
    {
        return DB::transaction(function () use ($data, $user) {
            $ticket = Ticket::create([
                'subject' => $data->subject,
                'body' => $data->body,
                'priority' => $data->priority,
                'status' => TicketStatus::OPEN,
                'user_id' => $user->getKey(),
            ]);

            $ticket->events()->create([
                'type' => TicketEventType::CREATED,
                'payload' => [
                    'subject' => $ticket->subject,
                    'priority' => $ticket->priority,
                    'author_id' => $ticket->user_id,
                ]
            ]);

            return $ticket;
        });
    }


}
