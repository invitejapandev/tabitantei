<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameProgress extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_event_id')->constrained()->onDelete('cascade');
            $table->integer('puzzle_progress')->nullable();
            $table->integer('answered_current')->nullable();
            $table->integer('time_answered')->nullable();
            $table->integer('teamNumber')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('game_progress');
    }
}
