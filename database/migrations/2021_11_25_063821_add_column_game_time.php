<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnGameTime extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('game_time', function (Blueprint $table) {
            $table->integer('puzzle_number')->nullable();
            $table->integer('game_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('game_time', function (Blueprint $table) {
            $table->dropColumn('puzzle_number')->nullable();
            $table->dropColumn('game_time')->nullable();
        });
    }
}
