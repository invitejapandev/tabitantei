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
use App\Models\GameHelp;
use App\Models\TeamMiro;
use App\Models\MapAnswer;
use App\Models\HintLog;
use App\Models\PlayerRevealedLog;

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
            'nickName' => 'Player '.$playerCount,
            'ActiveStatus' => 1
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

        if($request->puzzle_progress>=6){
            $puzzle_number = $request->puzzle_progress;
            $playerTeam =  $request->teamNumber;
            $event_id = $request->game_event_id;
            $teamMission = TeamMission::where('team_number', $playerTeam)->where('game_event_id', $event_id)->where('puzzle_number', $puzzle_number)->update(["is_commenced" => 1]);
        }

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

       
        $gameTime = GameTime::where('team_number', $team_number)->where('game_event_id', $game_event_id)->orderBy('created_at', 'ASC')->first();
        return array(
            'game_time' => $gameTime,
            'time_limit' => 60
        );
        
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
                'selected_color' => $selected_color,
                'is_validated' => 0
            );

            $pianoAnswer->update($newArray);
            return $newArray;
        }
        else{
            $newPiano = PianoAnswer::updateOrCreate(array(
                'game_event_id' => $game_event_id,
                'team_number' => $team_number,
                'player_name' => $player_name,
                'selected_color' => $selected_color,
                'is_validated' => 0
            ));
            
            $newPiano->save();
            return $newPiano;
        }

    }

    public function submit_color_map(Request $request){
        $game_event_id = $request->game_event_id;
        $team_number = $request->team_number;
        $player_name = $request->player_name;
        $selected_color = $request->selected_color;

        $mapAnswer = MapAnswer::where('game_event_id', $game_event_id)->where('team_number', $team_number)->where('player_name', $player_name)->first();

        if($mapAnswer){
            
            $newArray = array(
                'game_event_id' => $game_event_id,
                'team_number' => $team_number,
                'player_name' => $player_name,
                'selected_color' => $selected_color,
                'is_validated' => 0
            );

            $mapAnswer->update($newArray);
            return $newArray;
        }
        else{
            $newMapAnswer = mapAnswer::updateOrCreate(array(
                'game_event_id' => $game_event_id,
                'team_number' => $team_number,
                'player_name' => $player_name,
                'selected_color' => $selected_color,
                'is_validated' => 0
            ));
            
            $newMapAnswer->save();
            return $newMapAnswer;
        }

    }


    public function get_status_piano(Request $request){
        $gameStatus= TeamMiro::selectRaw('distinct team_number
        , (select count(distinct puzzle_progress) from game_progress where game_progress.teamNumber=team_miros.team_number group by game_progress.teamNumber) as GameProgress
        , ((select TIMESTAMPDIFF( SECOND,(select created_at from game_times where team_number = team_miros.team_number order by id desc limit 1), MAX(created_at) ) as Minutes_played from game_progress where teamNumber =  team_miros.team_number group by teamNumber)+(SELECT count(DISTINCT puzzle_number)*180 FROM hint_logs where hint_logs.team_number =team_miros.team_number)) as TotalSecond
        ')->orderBy('GameProgress','DESC')->orderBy('TotalSecond','asc')->take(5)->get();
        

        if(count($gameStatus) > 0){
            return $gameStatus;
        }
        
        return null;
        // return "No game status found.";
    }

    public function get_overall_result(Request $request){
        $gameStatus= TeamMiro::selectRaw('distinct team_number
        , (select count(distinct puzzle_progress) from game_progress where game_progress.teamNumber=team_miros.team_number group by game_progress.teamNumber) as GameProgress
        , ((select TIMESTAMPDIFF( SECOND,(select created_at from game_times where team_number = team_miros.team_number order by id desc limit 1), MAX(created_at) ) as Minutes_played from game_progress where teamNumber =  team_miros.team_number group by teamNumber)+(SELECT count(DISTINCT puzzle_number)*180 FROM hint_logs where hint_logs.team_number =team_miros.team_number)) as TotalSecond
        ')->orderBy('GameProgress','DESC')->orderBy('TotalSecond','asc')->take(12)->get();
        

        if(count($gameStatus) > 0){
            return $gameStatus;
        }
        
        return null;
        // return "No game status found.";
    }

    public function get_status_map(Request $request){
        $playerTeam = $request->playerTeam;
        $event_id = $request->game_event_id;
        $player_name = $request->player_name;
        $player_answer = $request->player_selected_color;
        $puzzle_progress = $request->puzzle_number;
        // return $player_answer['selected_color'];
        if($player_answer){
            $players = GamePlayer::where('teamNumber', $playerTeam)->where('game_event_id', $event_id)->get();
            $player_count = count($players);

            $mapAnswer= MapAnswer::where('game_event_id', $event_id)->where( 'team_number', $playerTeam)->where('selected_color', 'like' ,'%'.$player_answer.'%')->get();
            // $playerNotAnswer = GamePlayer::where('teamNumber', $playerTeam)->where('game_event_id', $event_id)->whereNotIn('nickName',PianoAnswer::select('player_name')->where('game_event_id', $event_id)->where( 'team_number', $playerTeam)->get() )->get();
            // $answerList= PianoAnswer::where('game_event_id', $event_id)->where( 'team_number', $playerTeam)->orderBy('player_name')->get();
            $gameStatus= GameProgress::where('game_event_id', $event_id)->where( 'teamNumber', $playerTeam)->where( 'puzzle_progress', $puzzle_progress)->get();
            $gameStatusData;
            if(count($gameStatus) > 0){
                 $gameStatusData = $gameStatus;
            }
            else{
                $gameStatusData = "No game data yet";
            }


            
            $playerAnswerList = GamePlayer::leftJoin('map_answers', 'game_players.nickName', '=', 'map_answers.player_name')->select('game_players.nickName', 'map_answers.selected_color')->where( 'game_players.teamNumber', $playerTeam)->orderBy('game_players.nickName')->get();
            if($mapAnswer){
                // return count($pianoAnswer);
                return $data = array(
                    'answered_player' => count($mapAnswer),
                    'player_count' => $player_count,
                    'selected_color' => $player_answer,
                    'mapAnswers' => $mapAnswer,
                    'playerAnswerList' => $playerAnswerList,
                    'gameStatus' =>$gameStatusData
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

        $gameStatus= GameProgress::select('game_event_id', 'puzzle_progress', 'answered_current', 'teamNumber')->distinct()->where('game_event_id', $event_id)->where( 'teamNumber', $playerTeam)->get();
        if(count($gameStatus) > 0){
            return $gameStatus;
        }
        
        return "No game status found.";
    }

    public function get_status_last_specific(Request $request){
        $playerTeam = $request->playerTeam;
        $event_id = $request->game_event_id;

        $gameStatus= GameProgress::where('game_event_id', $event_id)->where( 'teamNumber', $playerTeam)->orderByDesc('puzzle_progress')->first();
        if($gameStatus){
            if($gameStatus['puzzle_progress'] > 0){
                return $gameStatus['puzzle_progress'];
            }
        }
        
        return 0;
    }

    public function get_selected_mission(Request $request){
        $playerTeam = $request->playerTeam;
        $event_id = $request->game_event_id;
        $player_name = $request->player_number;
        $puzzle_number = $request->puzzle_number;
        
        $countData = TeamMission::where('team_number', $playerTeam)->where('is_commenced',0)->selectRaw('puzzle_number, count(*) as total_vote')->groupBy('puzzle_number')->orderByDesc('total_vote')->first();
        $selected_puzzle = 0;
        if($countData->total_vote>=2){
            $selected_puzzle = $countData->puzzle_number;
        }
        $data = array(
            'puzzle_selected' => $selected_puzzle
        );

        return $data;
    }

    public function get_selected_piano_answer(Request $request){
        $player_team = $request->player_team;
        $event_id = $request->game_event_id;
        $player_name = $request->player_name;
        $puzzle_number = $request-> puzzle_number;

        $playerAnswerList = GamePlayer::leftJoin('piano_answers', 'game_players.nickName', '=', 'piano_answers.player_name')->select('game_players.nickName', 'piano_answers.selected_color')->where( 'game_players.teamNumber', $player_team)->orderBy('game_players.nickName')->get();
        $countData = PianoAnswer::where('team_number', $player_team)->where('is_validated', 0)->selectRaw('selected_color, count(*) as total_vote')->groupBy('selected_color')->orderByDesc('total_vote')->first();
        $game_progress = GameProgress::where('teamNumber', $player_team)->where('puzzle_progress', 3)->first();
        $isFinished = 0;
        if($game_progress){
            $isFinished = 1;
        }
        $selected_color = '';
        if($countData)
        if($countData->total_vote >= 2){
            $selected_color = $countData->selected_color;
        }

        $data = array(
            'voted_color' => $selected_color,
            'playerAnswerList' => $playerAnswerList,
            'gameProgress' => $isFinished
        );

        return $data;
    }

    public function get_selected_map_answer(Request $request){
        $player_team = $request->player_team;
        $event_id = $request->game_event_id;
        $player_name = $request->player_name;
        $puzzle_number = $request-> puzzle_number;

        $playerAnswerList = GamePlayer::leftJoin('map_answers', 'game_players.nickName', '=', 'map_answers.player_name')->select('game_players.nickName', 'map_answers.selected_color')->where( 'game_players.teamNumber', $player_team)->orderBy('game_players.nickName')->get();
        $countData = MapAnswer::where('team_number', $player_team)->where('is_validated', 0)->selectRaw('selected_color, count(*) as total_vote')->groupBy('selected_color')->orderByDesc('total_vote')->first();
        $game_progress = GameProgress::where('teamNumber', $player_team)->where('puzzle_progress', 5)->first();
        $isfinished = 0;
        if($game_progress){
            $isfinished = 1;
        }
        $selected_color = '';
        if($countData)
        if($countData->total_vote >= 2){
            $selected_color = $countData->selected_color;
        }

        $data = array(
            'voted_color' => $selected_color,
            'playerAnswerList' => $playerAnswerList,
            'gameProgress' => $isfinished
        );

        return $data;
    }

    

    public function store_team_mission(Request $request){
        $playerTeam = $request->playerTeam;
        $event_id = $request->game_event_id;
        $player_name = $request->player_name;
        $puzzle_number = $request->puzzle_number;

        $teamMissionList = TeamMission::where('team_number', $playerTeam)->where('player_name', $player_name)->where('game_event_id', $event_id)->where("is_commenced", 0)->get();

        if(count($teamMissionList) == 0){
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
        else{

            $teamMission = TeamMission::where('team_number', $playerTeam)->where('player_name', $player_name)->where('game_event_id', $event_id)->where("is_commenced", 0)->update(["puzzle_number" => $puzzle_number]);
           
            return $teamMission;
        }

    }

    public function store_game_help(Request $request){
        $playerTeam = $request->playerTeam;
        $event_id = $request->game_event_id;
        $player_name = $request->player_name;
        $puzzle_number = $request->puzzle_number;

        
        $newGameHelp = new GameHelp([
            'game_event_id' => $event_id,
            'team_number' => $playerTeam,
            'player_name' => $player_name,
            'puzzle_number' => $puzzle_number,
            'isDone' => 0
        ]);
        
        $newGameHelp->save();

        return true;
    }

    public function update_team_mission(Request $request){
        
        $playerTeam = $request->playerTeam;
        $event_id = $request->game_event_id;
        $player_name = $request->player_name;
        $puzzle_number = $request->puzzle_number;

        $teamMission = TeamMission::where('team_number', $playerTeam)->where('game_event_id', $event_id)->update(["is_commenced" => 1]);

        return true;
    }

    public function update_piano_answer(Request $request){
        $player_team = $request->player_team;
        $event_id = $request->game_event_id;
        $player_name = $request->player_name;
        $puzzle_number = $request->puzzle_number;
        $selected_color = $request->selected_color;

        $pianoAnswer = PianoAnswer::where('team_number', $player_team)->where('selected_color',$selected_color)->where('game_event_id', $event_id)->update(["is_validated" => 1]);

        return true;
    }

    public function update_map_answer(Request $request){
        $player_team = $request->player_team;
        $event_id = $request->game_event_id;
        $player_name = $request->player_name;
        $puzzle_number = $request->puzzle_number;
        $selected_color = $request->selected_color;

        $pianoAnswer = MapAnswer::where('team_number', $player_team)->where('selected_color',$selected_color)->where('game_event_id', $event_id)->update(["is_validated" => 1]);

        return true;
    }

    public function game_help_list(){
        $gameHelp = GameHelp::where('isDone', 0)->get();

        return $gameHelp;
    }

    public function update_help(Request $request){
        $id = $request->id;
        $gameHelp = GameHelp::where('team_number', $id)->update(['isDone' => 1]);
        return true;
    }

    public function get_miro_link(Request $request){
        $puzzle_number = $request->puzzle_number;
        $team_number = $request->team_number;
        $miroBoard = TeamMiro::where('puzzle_number', $puzzle_number)->where('team_number', $team_number)->first();

        if($miroBoard)
        {
            return $miroBoard['miro_link'];
        }
        return "";
    }
    
    public function get_hint_log(Request $request){
        $puzzle_number = $request->puzzle_number;
        $team_number = $request->team_number;
        $game_event_id = $request->game_event_id;

        $hintLog = HintLog::where('game_event_id', $game_event_id)->where('puzzle_number', $puzzle_number)->where('team_number', $team_number)->orderby("id","desc")->first();

        if($hintLog){
            return 1;
        }
        
        return 0;
    }

    public function store_hint_log(Request $request){

        $puzzle_number = $request->puzzle_number;
        $team_number = $request->team_number;
        $game_event_id = $request->game_event_id;

        $newHintLog = HintLog::updateOrCreate(array(
            'game_event_id' => $game_event_id,
            'team_number' => $team_number,
            'puzzle_number' => $puzzle_number,
            'is_opened' => 1
        ));
        
        $newHintLog->save();
        return $newHintLog;

    }

    public function get_reveal_log(Request $request){
        $puzzle_number = $request->puzzle_number;
        $team_number = $request->team_number;
        $game_event_id = $request->game_event_id;
        $player_number = $request->player_number;

        $playerRevealedLog = PlayerRevealedLog::select('unlocked_hints')->where('player_number', $player_number)->where('game_event_id', $game_event_id)->where('puzzle_number', $puzzle_number)->where('team_number', $team_number)->orderby("id","desc")->first();

        if($playerRevealedLog){
            return $playerRevealedLog;
        }
        
        return 0;
    }
    

    public function store_reveal_log(Request $request){

        $puzzle_number = $request->puzzle_number;
        $team_number = $request->team_number;
        $game_event_id = $request->game_event_id;
        $player_number = $request->player_number;
        $unlocked_hints = $request->unlocked_hints;
        // $integerIDs = array_map('intval', explode(',', $unlocked_hints));
        $implodedHints = implode(",",$unlocked_hints);

        $newPlayerRevealLog = PlayerRevealedLog::updateOrCreate(array(
            'game_event_id' => $game_event_id,
            'team_number' => $team_number,
            'player_number' => $player_number,
            'puzzle_number' => $puzzle_number,
            'unlocked_hints' => $implodedHints
        ));
        
        $newPlayerRevealLog->save();
        return $newPlayerRevealLog;
    }

    public function get_game_event_details(){
        $currentGameEvent = GameEvent::where('game_events.Status', 1)->first();
        return $currentGameEvent;
    }
    
    public function get_game_events(){
        $gameEventList = GameEvent::get();
        return $gameEventList;
    }

    public function get_game_players(){
        $gamePlayerList = GamePlayer::get();
        return $gamePlayerList;
    }

    public function get_current_game_players(){
        $gamePlayerList = GamePlayer::where('game_event_id',
        function($query){
            $query->selectRaw('id')
            ->from('game_events')
            ->whereRaw('game_players.game_event_id = game_events.id');

        })->get();
        return $gamePlayerList;
    }
    
    public function get_current_status(Request $request){

        $gameStatus= TeamMiro::selectRaw('distinct team_number
        , (select count(id) from game_players where game_players.teamNumber = team_miros.team_number) as player_count
        , (select puzzle_progress from game_progress where game_progress.teamNumber = team_miros.team_number order by id desc limit 1) as puzzle_progress
        , (select  puzzle_number from team_missions  where team_missions.team_number = team_miros.team_number and is_commenced=0 group by puzzle_number order by count(id) desc limit 1 ) as select_paris
        , (select count(id) from game_helps where game_helps.team_number = team_miros.team_number and game_helps.isDone =0) as HelpCount
        , (select count(id) from game_helps where game_helps.team_number = team_miros.team_number) as HelpCountTotal
        , (select count(distinct puzzle_progress) from game_progress where game_progress.teamNumber=team_miros.team_number group by game_progress.teamNumber) as GameProgress
        , (select created_at from game_progress where game_progress.teamNumber=team_miros.team_number order by id desc limit 1) as LatestTime
        ,(select TIMESTAMPDIFF( SECOND,(select created_at from game_times where team_number = team_miros.team_number order by id desc limit 1), MAX(created_at) ) as Minutes_played from game_progress where teamNumber =  team_miros.team_number group by teamNumber) as TotalSecond
        ')->get();
        

        if(count($gameStatus) > 0){
            return $gameStatus;
        }
        
        return null;
    }
    
}
