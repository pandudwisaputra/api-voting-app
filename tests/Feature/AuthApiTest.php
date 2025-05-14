<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class AuthApiTest extends TestCase
{
    use RefreshDatabase;

    protected function authenticateAsUser()
    {
        $user = User::factory()->create(['role' => 'voter']);
        Sanctum::actingAs($user);
        return $user;
    }

    public function test_login()
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['token']);
    }

    public function test_profile()
    {
        $user = $this->authenticateAsUser();

        $response = $this->getJson("/api/profile");
        $response->assertStatus(200)
            ->assertJson([
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                ],
            ]);
    }

    public function test_logout()
    {
        $user = $this->authenticateAsUser();

        $response = $this->postJson("/api/logout");

        $response->assertStatus(200)
            ->assertJson(['message' => 'Logout berhasil']);
    }
}
