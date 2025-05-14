<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use App\Models\Candidate;
use App\Models\Vote;

class StatisticApiTest extends TestCase
{
    use RefreshDatabase;

    protected function authenticateAsAdmin()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        Sanctum::actingAs($admin);
        return $admin;
    }
   /** @test */
    public function statistic()
    {
        $this->authenticateAsAdmin();
        User::factory()->create();
        $candidate = Candidate::factory()->create();
        Vote::factory()->create();

        $response = $this->getJson("/api/statistics");
        $response->assertStatus(200)
            ->assertJson([
                'total_users' => 2,
                'total_votes' => 1,
                'total_candidates' => 1,
            ])
            ->assertJsonFragment([
                 'id' => $candidate->id,
                 'name' => $candidate->name,
                 'votes' => 1,
             ]);
    }
}
