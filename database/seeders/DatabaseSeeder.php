<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Candidate;
use App\Models\Vote;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Buat 1 admin secara manual
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'), // ganti password sesuai keinginan
            'role' => 'admin',
        ]);

        // Buat user biasa (role user)
        User::factory(10)->create([
            'role' => 'voter',
        ]);

        // Buat kandidat terlebih dahulu
        $candidates = \App\Models\Candidate::factory(5)->create();
    }
}
