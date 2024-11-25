<?php

namespace App\Http\Controllers;

use App\Services\ConfigService;
use Illuminate\Support\Facades\Http;
use WebSocket\Client;

class SongController extends Controller
{
    public function getSongs(string $searchString) {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . ConfigService::get('genius.access_token')
        ])
            ->get('https://api.genius.com/search?q=' . $searchString);
        return $response;
    }

    public function getLyrics(int $songId) {
        $client = new Client("ws://localhost:8080");

        $client->text("Get-Lyrics" . ";" . $songId . ";" . ConfigService::get('genius.access_token'));

        return $client->receive()->getContent();
    }
}
