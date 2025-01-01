<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\Auth\TraditionalAuthController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\IMSController;
use Database\Seeders\ArticleSeeder;

Route::post('/register', [TraditionalAuthController::class, 'register']);
Route::post('/login', [TraditionalAuthController::class, 'login']);
Route::middleware('auth:sanctum')->get('/me', [TraditionalAuthController::class, 'me']);
Route::middleware('auth:sanctum')->post('/logout', [TraditionalAuthController::class, 'logout']);

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/home', function () {
    return 'Welcome Home!';
})->middleware('auth');

Route::prefix('auth/{provider}')->group(function () {
    Route::get('/redirect', [SocialiteController::class, 'redirectToProvider']);
    Route::get('/callback', [SocialiteController::class, 'handleProviderCallback']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::apiResource('article', DataController::class);
});

Route::apiResource('ims',IMSController::class);
