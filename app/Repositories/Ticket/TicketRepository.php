<?php

declare(strict_types=1);

namespace App\Repositories\Ticket;

use App\DTO\Ticket\TicketCreateDTO;
use App\Enums\TicketEventType;
use App\Enums\TicketStatus;
use App\Models\Ticket;
use App\Models\User;
use App\Repositories\Ticket\TicketRepositoryContract;
use Illuminate\Support\Facades\DB;

final class TicketRepository implements TicketRepositoryContract
{

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
