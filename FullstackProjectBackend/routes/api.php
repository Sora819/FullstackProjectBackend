<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/search/{searchString}', [\App\Http\Controllers\SongController::class, 'getSongs']);
Route::get('/song/{searchString}', [\App\Http\Controllers\SongController::class, 'getLyrics']);

Route::post('/login', [\App\Http\Controllers\AuthenticationController::class, 'login']);
Route::post('/register', [\App\Http\Controllers\AuthenticationController::class, 'register']);
