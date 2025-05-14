<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Candidate;

class CandidateApiController extends Controller
{
    public function index()
    {
        $candidates = Candidate::all();
        return response()->json([
            'candidates' => $candidates,
        ]);
    }

    public function show($id)
    {
        $candidate = Candidate::findOrFail($id);
        return response()->json([
            'candidate' => $candidate,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $candidate = Candidate::create($request->only('name', 'description'));

        return response()->json([
            'message' => 'Kandidat berhasil ditambahkan',
            'candidate' => $candidate,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $candidate = Candidate::findOrFail($id);
        $candidate->update($request->only('name', 'description'));

        return response()->json([
            'message' => 'Kandidat berhasil diupdate',
            'candidate' => $candidate,
        ]);
    }

    public function destroy($id)
    {
        $candidate = Candidate::findOrFail($id);
        $candidate->delete();

        return response()->json([
            'message' => 'Kandidat berhasil dihapus',
        ]);
    }
}
