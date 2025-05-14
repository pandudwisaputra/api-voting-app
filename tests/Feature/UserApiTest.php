<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Laravel\Sanctum\Sanctum;

class UserApiTest extends TestCase
{
    use RefreshDatabase;

    protected function authenticateAsAdmin()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        Sanctum::actingAs($admin);
        return $admin;
    }

    protected function authenticateAsUser()
    {
        $user = User::factory()->create(['role' => 'voter']);
        Sanctum::actingAs($user);
        return $user;
    }

    /** @test */
    public function list_users()
    {
        $this->authenticateAsAdmin();

        $response = $this->getJson('/api/users');
        $response->assertStatus(200)
            ->assertJsonCount(1, 'data');
    }

    /** @test */
    public function detail_user()
    {
        $user = $this->authenticateAsAdmin();

        $response = $this->getJson("/api/users/{$user->id}");
        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                ],
            ]);
    }

    /** @test */
    public function create_user()
    {
        $this->authenticateAsAdmin();

        $response = $this->postJson('/api/users', [
            "name" => "user baru",
            "email" => "emailbaru@example.com",
            "password" => "password",
            "role" => "voter"
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'message' => "User created successfully",
                'data' => [
                    "name" => "user baru",
                    "email" => "emailbaru@example.com",
                    "role" => "voter"
                ],
            ]);

        $this->assertDatabaseHas('users', ['name' => 'user baru']);
    }
    /** @test */
    public function update_user()
    {
        $user = $this->authenticateAsAdmin();

        $response = $this->putJson("/api/users/{$user->id}", [
            "name" => "user update",
            "email" => "emailupdate@example.com",
            "role" => "admin"
        ]);
        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    "name" => "user update",
                    "email" => "emailupdate@example.com",
                    "role" => "admin"
                ],
            ]);
    }

    /** @test */
    public function delete_user()
    {
        $user = $this->authenticateAsAdmin();

        $response = $this->deleteJson("/api/users/{$user->id}");
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'User deleted',
            ]);

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }
}
