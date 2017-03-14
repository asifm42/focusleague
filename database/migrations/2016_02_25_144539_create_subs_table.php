<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('week_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->longtext('note')->nullable();
            $table->integer('team_id')->unsigned()->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('week_id')
                ->references('id')
                ->on('weeks');
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
        Schema::drop('subs');
    }
}
