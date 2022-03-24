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
    Route::post('/submit_color', [GameController::class, 'submit_color']);
    Route::post('/submit_color_map', [GameController::class, 'submit_color_map']);
    Route::post('/get_status_piano', [GameController::class, 'get_status_piano']);
    Route::post('/get_status_map', [GameController::class, 'get_status_map']);
    Route::post('/get_player_count', [GameController::class, 'get_player_count']);
    Route::post('/get_player_matrix', [GameController::class, 'get_player_matrix']);
    Route::post('/get_status_last', [GameController::class, 'get_status_last']);
    Route::post('/get_selected_mission', [GameController::class, 'get_selected_mission']);
    Route::post('/get_selected_piano_answer', [GameController::class, 'get_selected_piano_answer']);
    Route::post('/get_selected_map_answer', [GameController::class, 'get_selected_map_answer']);
    Route::post('/store_team_mission', [GameController::class, 'store_team_mission']);
    Route::post('/update_team_mission', [GameController::class, 'update_team_mission']);
    Route::post('/update_piano_answer', [GameController::class, 'update_piano_answer']);
    Route::post('/update_map_answer', [GameController::class, 'update_map_answer']);
    Route::post('/get_status_last_specific', [GameController::class, 'get_status_last_specific']);
    Route::post('/store_game_help', [GameController::class, 'store_game_help']);
    Route::post('/game_help_list', [GameController::class, 'game_help_list']);
    Route::post('/update_help', [GameController::class, 'update_help']);
    Route::post('/get_miro_link', [GameController::class, 'get_miro_link']);
    Route::post('/get_hint_log', [GameController::class, 'get_hint_log']);
    Route::post('/get_reveal_log', [GameController::class, 'get_reveal_log']);
    Route::post('/store_reveal_log', [GameController::class, 'store_reveal_log']);
    Route::post('/store_hint_log', [GameController::class, 'store_hint_log']);
});