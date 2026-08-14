<?php

namespace Tests\Feature;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class RegisterUserTest extends TestCase
{
    public function test_user_can_register_with_a_role(): void
    {
        Role::firstOrCreate([
            'name' => 'manager',
            'guard_name' => 'web',
        ]);

        $response = $this->postJson('/register', [
            'name' => 'Sovanrotha',
            'email' => 'sovanrotha+' . uniqid() . '@gmail.com',
            'password' => 'password123',
            'phone' => '098765432',
            'status' => 'active',
            'role' => 'manager',
        ]);

        $response->assertStatus(201)
            ->assertJsonPath('message', 'User registered successfully');

        $this->assertDatabaseHas('users', [
            'email' => $response->json('user.email'),
        ]);
    }

    public function test_user_can_login_with_email_and_password(): void
    {
        $user = User::factory()->create([
            'email' => 'login-' . uniqid() . '@example.com',
            'password' => bcrypt('password123'),
            'status' => 'active',
        ]);

        $response = $this->postJson('/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('message', 'Login successful');
    }
}
