<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\TicketEventType;
use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use App\Enums\UserRole;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'subject' => fake()->text(255),
            'body' => fake()->realText(500),
            'priority' => TicketPriority::NORMAL,
            'status' => TicketStatus::OPEN,
            'user_id' => User::query()
                ->where('role', UserRole::USER)
                ->inRandomOrder()
                ->first() ?? User::factory()->create(),
        ];
    }

    public function configure(): Factory
    {
        return $this->afterCreating(function (Ticket $ticket) {
            $ticket->events()->create([
                'type' => TicketEventType::CREATED,
                'payload' => [
                    'subject' => $ticket->subject,
                    'priority' => $ticket->priority,
                    'author_id' => $ticket->user_id,
                ],
            ]);
        });
    }
}
