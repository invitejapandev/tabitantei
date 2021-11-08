<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GamePlayer extends Migration
{
  
    public function up()
    {
        Schema::create('game_players', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_event_id')->constrained()->onDelete('cascade');
            $table->integer('teamNumber')->nullable();
            $table->string('nickName')->nullable();
            $table->integer('answeredPuzzle')->nullable();
        });
    }

    public function down()
    {
        //
        Schema::dropIfExists('game_players');
    }
}
