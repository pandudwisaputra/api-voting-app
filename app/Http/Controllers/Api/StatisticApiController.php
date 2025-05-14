<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Vote;
use App\Models\Candidate;

class StatisticApiController extends Controller
{
    // GET /api/statistics
    public function index()
    {
        $totalUsers = User::count();
        $totalVotes = Vote::count();
        $totalCandidates = Candidate::count();
        $votesPerCandidate = Candidate::withCount('votes')->get()->map(function ($candidate) {
            return [
                'id' => $candidate->id,
                'name' => $candidate->name,
                'votes' => $candidate->votes_count,
            ];
        });

        return response()->json([
            'total_users' => $totalUsers,
            'total_votes' => $totalVotes,
            'total_candidates' => $totalCandidates,
            'votes_per_candidate' => $votesPerCandidate,
        ]);
    }
}
