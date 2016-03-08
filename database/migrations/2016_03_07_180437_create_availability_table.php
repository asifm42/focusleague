<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAvailabilityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('availability', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('week_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->boolean('attending')->default(false);
            $table->timestamps();
            $table->softdeletes();

            // Foreign keys
            $table->foreign('week_id')
                ->references('id')
                ->on('weeks');
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
        Schema::drop('availability');
    }
}
