<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

final class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_register(): void
    {
        $data = [
            'name' => 'Goboz',
            'email' => 'gobozovbogdan@gmail.com',
            'password' => 'qwerty',
        ];
        $this->postJson('/api/register', $data)->assertStatus(204);
    }

    public function test_login()
    {
        $user = User::factory([
            'password' => 'qwerty',
        ])->create();

        $this->postJson('/api/login', ['email' => $user->email,
            'password' => 'qwerty',
            'fingerprint' => Str::random(20),
        ])
            ->assertJsonStructure([
                'data' => [
                    'access_token',
                    'refresh_token',
                    'type',
                    'expire_in_access',
                    'expire_in_refresh',
                ],
            ])
            ->assertStatus(200);
    }

    public function test_unauthorize()
    {
        $this->getJson('/api/me')->assertStatus(401);
    }

    public function test_login_validate()
    {
        User::factory([
            'password' => 'qwerty',
        ])->create();

        $this->postJson('/api/login')->assertStatus(422);
    }

    public function test_register_validate(): void
    {
        $data = [];
        $this->postJson('/api/register', $data)->assertStatus(422);
    }
}
