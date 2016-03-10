<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUltimateHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ultimate_history', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('club_affiliation');
            $table->string('years_played');
            $table->longtext('summary');
            $table->string('fav_defensive_position');
            $table->string('fav_offensive_position');
            $table->string('def_or_off');
            $table->string('best_skill');
            $table->string('skill_to_improve');
            $table->string('best_throw');
            $table->string('throw_to_improve');
            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ultimate_history');
    }
}
