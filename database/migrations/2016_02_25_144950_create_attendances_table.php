<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendences', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('week_id')->unsigned(); // should this be week_id???
            $table->integer('user_id')->unsigned();
            $table->integer('created_by')->unsigned();
            $table->timestamp('checkin');
            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('week_id')
                ->references('id')
                ->on('weeks');
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
            $table->foreign('created_by')
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
        Schema::drop('attendences');
    }
}
