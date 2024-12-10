<?php

namespace App\Http\Controllers;

use App\Models\Song;
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

    public function getSong(string $songId) {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . ConfigService::get('genius.access_token')
        ])
            ->get('https://api.genius.com/songs/' . $songId);
        return $response;
    }

    public function getLyrics(int $songId) {
        $song = Song::query()->where('genius_id', $songId)->first();

        if ($song) {
            return response()->json([
                'lyrics' => $song->lyrics,
                'song_id' => $song->id
            ]);
        }

        $song = $this->getSong($songId)->json()['response']['song'];

        $client = new Client("ws://localhost:8080");

        $client->text("Get-Lyrics" . ";" . $songId . ";" . ConfigService::get('genius.access_token'));

        $lyrics = $client->receive()->getContent();

        $songModel = Song::create([
            'genius_id' => $song['id'],
            'title' => $song['title'],
            'artist' => $song['primary_artist']['name'],
            'lyrics' => $lyrics,
            'word_count' => 0
        ]);

        return response()->json([
            'lyrics' => $lyrics,
            'song_id' => $songModel->id
        ]);
    }
}
