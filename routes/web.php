<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ResultController;

// Halaman awal
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Form login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

// Proses login
Route::post('/login', [AuthController::class, 'loginWeb'])->name('login.web');

// Proses logout
Route::get('/logout', [AuthController::class, 'logoutWeb'])->name('logout.web');

// Route yang membutuhkan autentikasi
Route::middleware('auth')->group(function () {
    // Halaman profil user
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile');

    // Lihat semua kandidat
    Route::get('/candidates', [CandidateController::class, 'publicIndex'])->name('candidates.index');

    // Form vote & submit vote
    Route::get('/vote', [VoteController::class, 'create'])->name('vote.create');
    Route::post('/vote', [VoteController::class, 'store'])->name('vote.store');
});

// Route admin
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    // Kelola kandidat
    Route::get('/candidates', [CandidateController::class, 'index'])->name('admin.candidates.index');
    Route::get('/candidates/create', [CandidateController::class, 'create'])->name('admin.candidates.create');
    Route::post('/candidates', [CandidateController::class, 'store'])->name('admin.candidates.store');
    Route::get('/candidates/{candidate}/edit', [CandidateController::class, 'edit'])->name('admin.candidates.edit');
    Route::put('/candidates/{candidate}', [CandidateController::class, 'update'])->name('admin.candidates.update');
    Route::delete('/candidates/{candidate}', [CandidateController::class, 'destroy'])->name('admin.candidates.destroy');

    // Hasil voting
    Route::get('/results', [ResultController::class, 'index'])->name('admin.results.index');
});
