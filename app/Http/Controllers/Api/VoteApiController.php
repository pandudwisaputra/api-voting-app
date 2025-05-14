<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vote;
use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoteApiController extends Controller
{
    // POST /api/vote
    public function store(Request $request)
    {
        $request->validate([
            'candidate_id' => 'required|exists:candidates,id',
        ]);

        $user = Auth::user();

        // Cek jika user sudah pernah vote
        if (Vote::where('user_id', $user->id)->exists()) {
            return response()->json(['message' => 'You have already voted.'], 403);
        }

        // Simpan vote
        $vote = Vote::create([
            'user_id' => $user->id,
            'candidate_id' => $request->candidate_id,
        ]);

        return response()->json(['message' => 'Vote submitted successfully', 'data' => $vote], 201);
    }

    // GET /api/vote
    public function show()
    {
        $vote = Vote::with('candidate')->where('user_id', Auth::id())->first();

        if (!$vote) {
            return response()->json(['message' => 'No vote found.'], 404);
        }

        return response()->json(['data' => $vote]);
    }

    // GET /api/votes
    public function index()
    {
        $votes = Vote::with(['user', 'candidate'])->get();
        return response()->json(['data' => $votes]);
    }
}
