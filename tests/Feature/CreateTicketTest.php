<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\TicketPriority;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

final class CreateTicketTest extends TestCase
{
    use RefreshDatabase;

    public function test_create(): void
    {
        $user = User::factory()->create();

        $data = [
            'subject' => 'Test Subject',
            'body' => 'Test Body',
            'priority' => TicketPriority::LOW->value,
        ];

        $response = $this->actingAs($user)->postJson('/api/tickets', $data);
        $response->assertStatus(201)->assertJsonStructure([
            'data' => ['id', 'subject', 'body', 'priority'],
        ]);

        $payload = $response->json();

        $id = $payload['data']['id'];

        $this->assertDatabaseHas('tickets', ['id' => $id]);
        $this->assertDatabaseHas('ticket_events', ['ticket_id' => $id]);
    }

    public function test_validate()
    {
        $user = User::factory()->create();

        $data = [];

        $response = $this->actingAs($user)->postJson('/api/tickets', $data);
        $response->assertStatus(422);
    }
}
