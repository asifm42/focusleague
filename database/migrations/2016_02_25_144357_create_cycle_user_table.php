<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCycleUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cycle_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cycle_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('div_pref_first');
            $table->string('div_pref_second')->nullable();
            $table->longtext('note')->nullable();
            $table->integer('team_id')->unsigned()->nullable();
            $table->boolean('captain')->default(false);
            $table->boolean('willing_to_captain')->default(false);
            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('cycle_id')
                ->references('id')
                ->on('cycles');
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
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
        Schema::drop('cycle_user');
    }
}
