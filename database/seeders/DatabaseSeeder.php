<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::factory()->admin()->create([
            'name' => 'admin',
            'email' => 'admin@demo',
        ]);

        User::factory()->agent()->create([
            'name' => 'agent',
            'email' => 'agent@demo',
        ]);

        User::factory()->create([
            'name' => 'user',
            'email' => 'user@demo',
        ]);

        Ticket::factory(10)->create();

    }
}
