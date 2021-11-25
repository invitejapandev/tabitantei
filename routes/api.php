<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/games', [GameController::class, 'index']);
Route::prefix('/game')->group(function (){
    Route::post('/validate_key', [GameController::class, 'validate_key']);
    Route::post('/store_player', [GameController::class, 'store_player']);
    Route::post('/get_status', [GameController::class, 'get_status']);
    Route::post('/store_status', [GameController::class, 'store_status']);
    Route::post('/store_game_time', [GameController::class, 'store_game_time']);
    Route::post('/get_game_time', [GameController::class, 'get_game_time']);
});