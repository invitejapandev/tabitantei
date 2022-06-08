<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForestanswer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('forest_answer', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_event_id')->constrained()->onDelete('cascade');
            $table->integer('team_number')->nullable();
            $table->string('color')->nullable();
            $table->string('selected_leter')->nullable();
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
        Schema::dropIfExists('forest_answer');
    }
}
