<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@demo',
        ]);

        User::factory()->create([
            'name' => 'agent',
            'email' => 'agent@demo',
        ]);

        User::factory()->create([
            'name' => 'user',
            'email' => 'user@demo',
        ]);

    }
}
