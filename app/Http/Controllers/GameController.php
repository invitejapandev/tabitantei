<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GameEvent;
use App\Models\GamePlayer;
use App\Models\GameProgress;
use App\Models\GameTime;

class GameController extends Controller
{
    //
    public function index(){
        return GameEvent::orderBy('created_at', 'DESC')->get();
    }

    public function validate_key(Request $request){
        // dd($request);
        $gameCode = $request->code;

        $gameData = GameEvent::where('game_code', '=', $gameCode)->get();

        if($gameData){
            return $gameData;
        }

        return "No game found.";
    }

    public function store_player(Request $request){
       
        
        $playerList = GamePlayer::where('game_event_id', $request->game_event_id)->get();
        $playerCount = $playerList->count();

        $player = new GamePlayer([
            'game_event_id' => $request->game_event_id,
            'teamNumber' => $request->teamNumber,
            'nickName' => 'Player '.$playerCount
        ]);
        
        $player->save();

        return $playerCount+1;
    }

    public function get_status(Request $request){
        $playerTeam = $request->playerTeam;
        $event_id = $request->game_event_id;
        $puzzle_progress = $request->puzzleNumber;

        $gameStatus= GameProgress::where('game_event_id', $event_id)->where( 'teamNumber', $playerTeam)->where( 'puzzle_progress', $puzzle_progress)->get();
        if(count($gameStatus) > 0){
            return $gameStatus;
        }
        
        return "No game status found.";
    }

    public function store_status(Request $request){

        $gameProgress = new GameProgress([
            'game_event_id' => $request->game_event_id,
            'teamNumber' => $request->teamNumber,
            'puzzle_progress' => $request->puzzle_progress,
            'player_number' => $request->player_number,
            'answered_current' => 1
        ]);

        $gameProgress->save();

        return true;
    }

    public function store_game_time(Request $request){

        $gameTime = new GameTime ([
            'game_event_id' => $request->game_event_id,
            'puzzle_number' => $request->puzzle_number,
            'game_time' => $request->game_time,
            'team_number' => $request->team_number
        ]);

        $gameTime->save();
        return true;
    }

    public function get_game_time(Request $request){
        $puzzle_number = $request->puzzle_number;
        $team_number = $request->team_number;
        $game_event_id = $request->game_event_id;

       
        return GameTime::where('puzzle_number', $puzzle_number)->where('team_number', $team_number)->where('game_event_id', $game_event_id)->orderBy('created_at', 'ASC')->first();
        
    }
}
