<?php

namespace App\Http\Controllers;

use App\Models\Result;
use Illuminate\Support\Facades\Request;

class ResultController extends Controller
{
    public function getLeaderboard(): \Illuminate\Database\Eloquent\Collection
    {
        $results = Result::query()->orderByDesc('correct')->orderByDesc('time')->limit(10);
        return $results->get();
    }

    public function saveResult(Request $request): void
    {
        Result::create([
            'user_id' => $request->input('user_id'),
            'song_id' => $request->input('song_id'),
            'guess_count' => $request->input('guess_count'),
            'correct' => $request->input('correct'),
            'time' => $request->input('time'),
        ]);
    }
}
