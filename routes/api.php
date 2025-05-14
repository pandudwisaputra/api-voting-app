<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\CandidateApiController;
use App\Http\Controllers\Api\VoteApiController;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\StatisticApiController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthApiController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [AuthApiController::class, 'profile']);
    Route::post('/logout', [AuthApiController::class, 'logout']);
    Route::get('/candidates', [CandidateApiController::class, 'index']);
    Route::get('/candidates/{id}', [CandidateApiController::class, 'show']);
    Route::post('/candidates', [CandidateApiController::class, 'store'])->middleware('admin');
    Route::put('/candidates/{id}', [CandidateApiController::class, 'update'])->middleware('admin');
    Route::delete('/candidates/{id}', [CandidateApiController::class, 'destroy'])->middleware('admin');
    Route::post('/vote', [VoteApiController::class, 'store']);
    Route::get('/vote', [VoteApiController::class, 'show']);
    Route::get('/votes', [VoteApiController::class, 'index'])->middleware('admin');
    Route::get('/users', [UserApiController::class, 'index'])->middleware('admin');
    Route::get('/users/{id}', [UserApiController::class, 'show'])->middleware('admin');
    Route::post('/users', [UserApiController::class, 'store'])->middleware('admin');
    Route::put('/users/{id}', [UserApiController::class, 'update'])->middleware('admin');
    Route::delete('/users/{id}', [UserApiController::class, 'destroy'])->middleware('admin');
    Route::get('/statistics', [StatisticApiController::class, 'index'])->middleware('admin');
});
