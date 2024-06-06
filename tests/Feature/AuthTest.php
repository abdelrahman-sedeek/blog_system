<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_registration()
    {
        $userData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',

        ];

        $response = $this->postJson('/api/register', $userData);

        $response->assertStatus(201);
        $this->assertDatabaseHas('users', ['email' => 'test@example.com']);
    }

    public function test_user_login()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        $loginData = [
            'email' => 'test@example.com',
            'password' => 'password',
        ];

        $response = $this->postJson('/api/login', $loginData);

        $response->assertStatus(200);
        $response->assertJsonStructure(['access_token', 'token_type']);
    }
}
