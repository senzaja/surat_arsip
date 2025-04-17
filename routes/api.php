<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IncomingController;
use App\Http\Controllers\OutgoingController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    Route::post('/register', [\App\Http\Controllers\Api\AuthController::class, 'register']);
    // Route::get('/Api/incoming', [\App\Http\Controllers\Api\IncomingController::class, 'index']);
    Route::get('/outgoing', [OutgoingController::class, 'indexapi']);
    Route::get('/incoming', [IncomingController::class, 'indexapi']);

    return $request->user();
});


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/register', [\App\Http\Controllers\Api\AuthController::class, 'register']);
    Route::get('/outgoing', [OutgoingController::class, 'indexapi']);
    Route::get('/incoming', [IncomingController::class, 'indexapi']);
    Route::get('/incoming', [\App\Http\Controllers\Api\IncomingController::class, 'index']);
});
    