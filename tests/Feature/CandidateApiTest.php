<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Candidate;
use Laravel\Sanctum\Sanctum;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CandidateApiTest extends TestCase
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
    public function list_candidates()
    {
        $this->authenticateAsUser();
        Candidate::factory()->count(3)->create();

        $response = $this->getJson('/api/candidates');
        $response->assertStatus(200)
            ->assertJsonCount(3, 'candidates');
    }

    /** @test */
    public function candidate_detail()
    {
        $this->authenticateAsAdmin();
        $candidate = Candidate::factory()->create();

        $response = $this->getJson("/api/candidates/{$candidate->id}");
        $response->assertStatus(200)
            ->assertJson([
                'candidate' => [
                    'id' => $candidate->id,
                    'name' => $candidate->name,
                    'description' => $candidate->description,
                ],
            ]);
    }


    /** @test */
    public function create_candidate()
    {
        $this->authenticateAsAdmin();

        $response = $this->postJson('/api/candidates', [
            'name' => 'Candidate Baru',
            'description' => 'Deskripsi calon',
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'candidate' => [
                    'name' => 'Candidate Baru',
                    'description' => 'Deskripsi calon',
                ],
            ]);

        $this->assertDatabaseHas('candidates', ['name' => 'Candidate Baru']);
    }


    /** @test */
    public function update_candidate()
    {
        $this->authenticateAsAdmin();
        $candidate = Candidate::factory()->create();

        $response = $this->putJson("/api/candidates/{$candidate->id}", [
            'name' => 'Nama Update',
            'description' => 'Deskripsi Update',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Kandidat berhasil diupdate',
                'candidate' => [
                    'id' => $candidate->id,
                    'name' => 'Nama Update',
                    'description' => 'Deskripsi Update',
                ],
            ]);
    }

    /** @test */
    public function delete_candidate()
    {
        $this->authenticateAsAdmin();
        $candidate = Candidate::factory()->create();

        $response = $this->deleteJson("/api/candidates/{$candidate->id}");
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Kandidat berhasil dihapus',
            ]);

        $this->assertDatabaseMissing('candidates', ['id' => $candidate->id]);
    }
}
