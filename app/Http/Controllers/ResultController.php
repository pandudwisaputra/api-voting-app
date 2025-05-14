<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    public function index()
    {
        $candidates = Candidate::withCount('votes')->get();
        return view('admin.results.index', compact('candidates'));
    }
}
