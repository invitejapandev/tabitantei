<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GameEvent;
use App\Models\GamePlayer;
use App\Models\GameProgress;
use App\Models\GameTime;
use App\Models\PianoAnswer;
use App\Models\SecurityMatrix;
use App\Models\TeamMission;

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
        $playerCount += 1;

        $player = new GamePlayer([
            'game_event_id' => $request->game_event_id,
            'teamNumber' => $request->teamNumber,
            'nickName' => 'Player '.$playerCount
        ]);
        
        $player->save();

        return $playerCount;
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

       
        return GameTime::where('team_number', $team_number)->where('game_event_id', $game_event_id)->orderBy('created_at', 'ASC')->first();
        
    }

    public function submit_color(Request $request){
        $game_event_id = $request->game_event_id;
        $team_number = $request->team_number;
        $player_name = $request->player_name;
        $selected_color = $request->selected_color;

        $pianoAnswer = PianoAnswer::where('game_event_id', $game_event_id)->where('team_number', $team_number)->where('player_name', $player_name)->first();

        if($pianoAnswer){
            
            $newArray = array(
                'game_event_id' => $game_event_id,
                'team_number' => $team_number,
                'player_name' => $player_name,
                'selected_color' => $selected_color
            );

            $pianoAnswer->update($newArray);
            return $newArray;
        }
        else{
            $newPiano = PianoAnswer::updateOrCreate(array(
                'game_event_id' => $game_event_id,
                'team_number' => $team_number,
                'player_name' => $player_name,
                'selected_color' => $selected_color
            ));
            
            $newPiano->save();
            return $newPiano;
        }

    }


    public function get_status_piano(Request $request){
        $playerTeam = $request->playerTeam;
        $event_id = $request->game_event_id;
        $player_name = $request->player_name;
        $player_answer = PianoAnswer::select('selected_color')->where('game_event_id', $event_id)->where('team_number', $playerTeam)->where('player_name', $player_name)->first();
        // return $player_answer['selected_color'];
        if($player_answer){
            $players = GamePlayer::where('teamNumber', $playerTeam)->where('game_event_id', $event_id)->get();
            $player_count = count($players);

            $pianoAnswer= PianoAnswer::where('game_event_id', $event_id)->where( 'team_number', $playerTeam)->where('selected_color', $player_answer['selected_color'])->get();
            if($pianoAnswer){
                // return count($pianoAnswer);
                return $data = array(
                    'answered_player' => count($pianoAnswer),
                    'player_count' => $player_count,
                    'selected_color' => $player_answer['selected_color']
                );
            }
            else{
                return "No answers yet";
            }
        }
        return "No answers yet";
        // return "No game status found.";
    }

    public function get_player_count(Request $request){
        
        $playerTeam = $request->playerTeam;
        $event_id = $request->game_event_id;
        $player_name = $request->player_name;

        $players = GamePlayer::where('teamNumber', $playerTeam)->where('game_event_id', $event_id)->get();
        $player_count = count($players);
        
        return $players;

    }

    public function get_player_matrix(Request $request){
        $player_number = $request->player_index;
        $player_count = $request->player_count;
        
        $matrix = SecurityMatrix::where('player_number', $player_number)->where('player_count', $player_count)->first();

        return $matrix;
    }


    public function get_status_last(Request $request){
        $playerTeam = $request->playerTeam;
        $event_id = $request->game_event_id;

        $gameStatus= GameProgress::where('game_event_id', $event_id)->where( 'teamNumber', $playerTeam)->get();
        if(count($gameStatus) > 0){
            return $gameStatus;
        }
        
        return "No game status found.";
    }

    public function get_selected_mission(Request $request){
        $playerTeam = $request->playerTeam;
        $event_id = $request->game_event_id;
        $player_name = $request->player_number;

        $teamMission = TeamMission::where('team_number', $playerTeam)->where('player_name','!=', $player_name)->where('game_event_id', $event_id)->where('is_commenced', 0)->first();


        return $teamMission;
    }

    

    public function store_team_mission(Request $request){
        $playerTeam = $request->playerTeam;
        $event_id = $request->game_event_id;
        $player_name = $request->player_name;
        $puzzle_number = $request->puzzle_number;

        $newTeamMission = TeamMission::updateOrCreate(array(
            'game_event_id' => $event_id,
            'team_number' => $playerTeam,
            'player_name' => $player_name,
            'puzzle_number' => $puzzle_number,
            'is_commenced' => 0
        ));
        
        $newTeamMission->save();
        

        // $teamMission = TeamMission::where('team_number', $playerTeam)->where('game_event_id', $event_id)->where('is_commenced', 1)->first();
        return $newTeamMission;
    }

    public function update_team_mission(Request $request){
        
        $playerTeam = $request->playerTeam;
        $event_id = $request->game_event_id;
        $player_name = $request->player_name;
        $puzzle_number = $request->puzzle_number;

        $teamMission = TeamMission::where('team_number', $playerTeam)->where('game_event_id', $event_id)->where('puzzle_number', $puzzle_number)->first();

        if($teamMission){
            $newArray = array(
                'game_event_id' => $event_id,
                'team_number' => $playerTeam,
                'player_name' => $player_name,
                'puzzle_number' => $puzzle_number,
                'is_commenced' => 1
            );

            $teamMission->update($newArray);
            return true;
        }
    }

    
    
}
