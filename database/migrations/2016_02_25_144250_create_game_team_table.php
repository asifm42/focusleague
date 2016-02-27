<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameTeamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_team', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('game_id')->unsigned();
            $table->integer('team_id')->unsigned();
            $table->integer('points_scored');
            $table->timestamps();

            // Foreign keys
            $table->foreign('game_id')
                ->references('id')
                ->on('games');
            $table->foreign('team_id')
                ->references('id')
                ->on('teams');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('game_team');
    }
}
