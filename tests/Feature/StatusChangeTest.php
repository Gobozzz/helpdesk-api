<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\TicketStatus;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class StatusChangeTest extends TestCase
{
    use RefreshDatabase;

    public function test_status_change(): void
    {
        $agent = User::factory()->agent()->create();
        $admin = User::factory()->admin()->create();
        $ticket = Ticket::factory([
            'assigned_user_id' => $agent->getKey(),
        ])->create();

        $this->actingAs($agent)->postJson("/api/tickets/{$ticket->getKey()}/status", [
            'status' => TicketStatus::IN_PROGRESS,
        ])->assertStatus(200);

        $this->assertDatabaseHas('tickets', ['id' => $ticket->getKey(), 'status' => TicketStatus::IN_PROGRESS]);

        $this->actingAs($admin)->postJson("/api/tickets/{$ticket->getKey()}/status", [
            'status' => TicketStatus::CLOSED,
        ])->assertStatus(200);

        $this->assertDatabaseHas('tickets', ['id' => $ticket->getKey(), 'status' => TicketStatus::CLOSED]);
    }

    public function test_status_change_not_permission(): void
    {
        $agent = User::factory()->agent()->create();
        $agent_2 = User::factory()->agent()->create();
        $ticket = Ticket::factory([
            'assigned_user_id' => $agent->getKey(),
        ])->create();

        $this->actingAs($agent_2)->postJson("/api/tickets/{$ticket->getKey()}/status", [
            'status' => TicketStatus::IN_PROGRESS,
        ])->assertStatus(403);
    }

    public function test_status_change_validate(): void
    {
        $agent = User::factory()->agent()->create();
        $ticket = Ticket::factory([
            'assigned_user_id' => $agent->getKey(),
        ])->create();

        $this->actingAs($agent)->postJson("/api/tickets/{$ticket->getKey()}/status", [])->assertStatus(422);
    }
}
