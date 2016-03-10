<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('nickname')->unique();
            $table->string('email')->unique();
            $table->string('password', 60);
            $table->boolean('confirmed')->default(0);
            $table->string('confirmation_code')->nullable();
            $table->rememberToken();
            $table->enum('gender', ['male', 'female']);
            $table->date('birthday');
            $table->string('cell_number', 100);
            $table->string('mobile_carrier');
            $table->enum('dominant_hand', ['left', 'right']);
            $table->integer('height');
            $table->string('division_preference_first');
            $table->string('division_preference_second')->nullable();
            $table->string('image');
            $table->boolean('admin')->default(false);
            $table->timestamp('season_pass_ends_on')->nullable();
            $table->string('ip_address')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
