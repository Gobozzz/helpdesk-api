<?php

declare(strict_types=1);

namespace App\Repositories\Ticket;

use App\DTO\Ticket\TicketChangeStatusDTO;
use App\DTO\Ticket\TicketCommentDTO;
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
    private const PAGINATE_GET_ALL = 10;

    public function comment(Ticket $ticket, TicketCommentDTO $data): Ticket
    {
        $ticket->events()->create([
            'type' => TicketEventType::COMMENT,
            'payload' => [
                'text' => $data->text,
                'author_id' => $data->user_id,
            ]
        ]);

        return $ticket;
    }

    public function setStatus(Ticket $ticket, TicketChangeStatusDTO $data): Ticket
    {
        return DB::transaction(function () use ($ticket, $data) {
            $ticket->updateOrFail([
                'status' => $data->status,
            ]);

            $ticket->events()->create([
                'type' => TicketEventType::STATUS_CHANGED,
                'payload' => [
                    'priority' => $ticket->priority,
                    'status' => $ticket->status,
                    'user_id_set_status' => $data->user_id,
                ]
            ]);

            return $ticket;
        });
    }

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

    public function getById(string $id): Ticket
    {
        return Ticket::query()
            ->with(['events' => fn($q) => $q->latest()])
            ->findOrFail($id);
    }

    public function create(TicketCreateDTO $data): Ticket
    {
        return DB::transaction(function () use ($data) {
            $ticket = Ticket::create([
                'subject' => $data->subject,
                'body' => $data->body,
                'priority' => $data->priority,
                'status' => TicketStatus::OPEN,
                'user_id' => $data->user_id,
            ]);

            $ticket->events()->create([
                'type' => TicketEventType::CREATED,
                'payload' => [
                    'subject' => $ticket->subject,
                    'body' => $data->body,
                    'priority' => $ticket->priority,
                    'author_id' => $ticket->user_id,
                ]
            ]);

            return $ticket;
        });
    }

    public function updateAssignId(Ticket $ticket, string|int $assignId): Ticket
    {

        return DB::transaction(function () use ($ticket, $assignId) {
            $ticket->updateOrFail([
                'assigned_user_id' => $assignId,
            ]);

            $ticket->events()->create([
                'type' => TicketEventType::ASSIGNED,
                'payload' => [
                    'priority' => $ticket->priority,
                    'assigned_user_id' => $ticket->assigned_user_id,
                ]
            ]);

            return $ticket;
        });
    }


}
