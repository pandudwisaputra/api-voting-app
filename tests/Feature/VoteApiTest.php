<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use App\Models\Candidate;
use App\Models\Vote;

class VoteApiTest extends TestCase
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
    public function vote_candidate()
    {
        $this->authenticateAsUser();
        $candidate = Candidate::factory()->create();

        $response = $this->postJson("/api/vote", [
            'candidate_id' => $candidate->id
        ]);
        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Vote submitted successfully',
                'data' => [
                    'candidate_id' => $candidate->id,
                ],
            ]);

        $this->assertDatabaseHas('votes', ['candidate_id' => $candidate->id]);
    }

    /** @test */
    public function vote_detail()
    {
        $user = $this->authenticateAsUser();

        $candidate = Candidate::factory()->create();

        $vote = Vote::factory()->create(
            [
                "user_id" => $user->id,
                "candidate_id" => $candidate->id,
            ],
        );

        $response = $this->getJson("/api/vote");
        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'user_id' => $user->id,
                ],
            ]);
    }

    /** @test */
    public function list_votes()
    {
        $user = $this->authenticateAsAdmin();

        $candidate = Candidate::factory()->create();

        $vote = Vote::factory()->create(
            [
                "user_id" => $user->id,
                "candidate_id" => $candidate->id,
            ],
        );

        $response = $this->getJson('/api/votes');
        $response->assertStatus(200)
            ->assertJsonCount(1, 'data');
    }
}
