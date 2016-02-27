<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->enum('type', ['charge', 'credit', 'payment']);
            $table->string('payment_type')->nullable();
            $table->string('description');
            $table->integer('amount');
            $table->integer('created_by')->unsigned();
            $table->timestamps();


            //foreign keys
            $table->foreign('created_by')
                ->references('id')
                ->on('users');
            //foreign keys
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
        Schema::drop('transactions');
    }
}
