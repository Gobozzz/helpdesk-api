<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\TicketEventType;
use App\Jobs\SendTicketEmailJob;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

final class QueueTest extends TestCase
{
    use RefreshDatabase;

    public function test_send_outbox_email(): void
    {
        Queue::fake();
        $user = User::factory()->create();
        $ticket = Ticket::factory()->create([
            'user_id' => $user->getKey(),
        ]);

        $this->actingAs($user)->postJson("/api/tickets/{$ticket->getKey()}/comment", [
            'text' => 'Комментарий от пользователя',
        ])->assertStatus(200);

        Queue::assertPushed(SendTicketEmailJob::class, function ($job) {
            $job->handle();

            return true;
        });

        $this->assertDatabaseHas('outbox_emails', [
            'ticket_id' => $ticket->getKey(),
            'event_type' => TicketEventType::COMMENT,
        ]);
    }
}
