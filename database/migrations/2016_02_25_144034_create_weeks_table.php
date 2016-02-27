<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeeksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weeks', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cycle_id')->unsigned();
            $table->timestamp('starts_at');
            $table->timestamp('ends_at');
            $table->boolean('rained_out');
            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('cycle_id')
                ->references('id')
                ->on('cycles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('weeks');
    }
}
