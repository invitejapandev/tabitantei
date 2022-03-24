<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHintLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hint_log', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_event_id')->constrained()->onDelete('cascade');
            $table->integer('team_number')->nullable();
            $table->integer('puzzle_number')->nullable();
            $table->boolean('is_opened')->nullable();
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
        Schema::dropIfExists('hint_log');
    }
}
