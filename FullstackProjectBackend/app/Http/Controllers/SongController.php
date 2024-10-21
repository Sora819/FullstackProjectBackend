<?php

namespace App\Http\Controllers;

use App\Services\ConfigService;
use Illuminate\Support\Facades\Http;

class SongController extends Controller
{
    public function getSongs(string $searchString) {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . ConfigService::get('genius.access_token')
        ])
            ->get('https://api.genius.com/search?q=' . $searchString);
        return $response;
    }

    public function getLyrics() {
        // @TODO: Get the lyrics of a song based on song id
    }
}
