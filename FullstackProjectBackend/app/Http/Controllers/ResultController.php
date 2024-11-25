<?php

namespace App\Http\Controllers;

use App\Models\Result;

class ResultController extends Controller
{
    public function getLeaderboard(): \Illuminate\Database\Eloquent\Collection
    {
        $results = Result::query()->orderByDesc('correct')->orderByDesc('time')->limit(10);
        return $results->get();
    }
}
