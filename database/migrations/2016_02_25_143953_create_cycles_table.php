<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCyclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cycles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('created_by')->unsigned();
            $table->timestamp('signup_opens_at')->nullable();;
            $table->timestamp('signup_closes_at')->nullable();;
            $table->timestamp('starts_at');
            $table->timestamp('ends_at');
            $table->string('name');
            $table->string('format');
            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
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
        Schema::drop('cycles');
    }
}
