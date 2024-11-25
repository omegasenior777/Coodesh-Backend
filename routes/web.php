<?php

use App\Http\Controllers\DictionaryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/home', function () {
    return view('welcome');
});
//Route::get('/csrf-token', function() {
//    return response()->json(['csrf_token' => csrf_token()]);
//});

Route::get('/', function () {
    return response()->json(['message' => 'Fullstack Challenge 🏅 - Dictionary']);
});

Route::prefix('auth')->group(function () {
    Route::post('/signup', [AuthController::class, 'signup'])->withoutMiddleware([VerifyCsrfToken::class]);
    Route::post('/signin', [AuthController::class, 'signin'])->withoutMiddleware([VerifyCsrfToken::class]);
    Route::post('/logout', [AuthController::class, 'logout'])->withoutMiddleware([VerifyCsrfToken::class]);
});

Route::prefix('entries')->group(function () {
    Route::get('/en', [DictionaryController::class, 'index']);
    Route::get('/en/{word}', [DictionaryController::class, 'show'])->middleware('auth:sanctum');
    Route::post('/en/{word}/favorite', [DictionaryController::class, 'favorite'])->withoutMiddleware([VerifyCsrfToken::class]);
    Route::delete('/en/{word}/unfavorite', [DictionaryController::class, 'unfavorite'])->withoutMiddleware([VerifyCsrfToken::class]);
});
Route::prefix('user/me')->middleware('auth:sanctum')->group(function () {
    Route::get('/', [UserController::class, 'profile']);
    Route::get('/history', [UserController::class, 'history']);
    Route::get('/favorites', [UserController::class, 'favorites']);
});
