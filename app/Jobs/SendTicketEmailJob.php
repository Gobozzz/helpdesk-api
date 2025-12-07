<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Enums\TicketEventType;
use App\Models\OutboxEmail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

final class SendTicketEmailJob implements ShouldQueue
{
    use Queueable;

    public function __construct(private readonly string|int $ticketId, private readonly TicketEventType $eventType) {}

    public function handle(): void
    {
        OutboxEmail::create([
            'ticket_id' => $this->ticketId,
            'event_type' => $this->eventType,
        ]);
    }
}
