<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class AccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_access(): void
    {
        $user_1 = User::factory()->create();
        $user_2 = User::factory()->create();
        $agent = User::factory()->agent()->create();
        $admin = User::factory()->admin()->create();

        $ticket = Ticket::factory([
            'user_id' => $user_1->getKey(),
            'assigned_user_id' => $agent->getKey(),
        ])->create();

        $this->actingAs($user_1)->getJson("/api/tickets/{$ticket->getKey()}")->assertStatus(200);
        $this->actingAs($admin)->getJson("/api/tickets/{$ticket->getKey()}")->assertStatus(200);
        $this->actingAs($agent)->getJson("/api/tickets/{$ticket->getKey()}")->assertStatus(200);
        $this->actingAs($user_2)->getJson("/api/tickets/{$ticket->getKey()}")->assertStatus(403);

    }
}
