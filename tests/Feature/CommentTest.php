<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\TicketEventType;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class CommentTest extends TestCase
{
    use RefreshDatabase;

    public function test_comment_create()
    {
        $user = User::factory()->create();
        $agent = User::factory()->agent()->create();
        $admin = User::factory()->admin()->create();

        $ticket = Ticket::factory([
            'assigned_user_id' => $agent->getKey(),
            'user_id' => $user->getKey(),
        ])->create();

        $this->actingAs($user)->postJson("/api/tickets/{$ticket->getKey()}/comment", [
            'text' => 'Комментарий пользователя',
        ])->assertStatus(200);

        $this->assertDatabaseHas('ticket_events', ['ticket_id' => $ticket->getKey(), 'type' => TicketEventType::COMMENT]);

        $this->actingAs($agent)->postJson("/api/tickets/{$ticket->getKey()}/comment", [
            'text' => 'Комментарий агента',
        ])->assertStatus(200);

        $this->assertDatabaseHas('ticket_events', ['ticket_id' => $ticket->getKey(), 'type' => TicketEventType::COMMENT]);

        $this->actingAs($admin)->postJson("/api/tickets/{$ticket->getKey()}/comment", [
            'text' => 'Комментарий админа',
        ])->assertStatus(200);

        $this->assertDatabaseHas('ticket_events', ['ticket_id' => $ticket->getKey(), 'type' => TicketEventType::COMMENT]);
    }

    public function test_comment_create_not_permission()
    {
        $user = User::factory()->create();
        $user_2 = User::factory()->create();
        $agent = User::factory()->agent()->create();
        $agent_2 = User::factory()->agent()->create();

        $ticket = Ticket::factory([
            'assigned_user_id' => $agent->getKey(),
            'user_id' => $user->getKey(),
        ])->create();

        $this->actingAs($user_2)->postJson("/api/tickets/{$ticket->getKey()}/comment", [
            'text' => 'Комментарий пользователя',
        ])->assertStatus(403);

        $this->actingAs($agent_2)->postJson("/api/tickets/{$ticket->getKey()}/comment", [
            'text' => 'Комментарий агента',
        ])->assertStatus(403);

    }

    public function test_comment_create_validate()
    {
        $user = User::factory()->create();

        $ticket = Ticket::factory([
            'user_id' => $user->getKey(),
        ])->create();

        $this->actingAs($user)->postJson("/api/tickets/{$ticket->getKey()}/comment", [])->assertStatus(422);
    }
}
