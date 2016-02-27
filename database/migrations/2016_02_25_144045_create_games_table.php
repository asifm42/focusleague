<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('week_id')->unsigned();
            $table->timestamp('starts_at');
            $table->timestamp('ends_at');
            $table->boolean('rained_out');
            $table->string('field');
            $table->string('division');
            $table->string('format');
            $table->integer('created_by');
            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('week_id')
                ->references('id')
                ->on('weeks');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('games');
    }
}
