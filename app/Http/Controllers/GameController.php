<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GameEvent;
use App\Models\GamePlayer;

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

        return $playerCount;
    }
}
