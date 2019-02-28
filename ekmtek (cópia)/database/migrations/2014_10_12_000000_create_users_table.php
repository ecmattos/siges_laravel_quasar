<?php

use Illuminate\Support\Facades\Schema;
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

            $table->boolean('verified')->default(false);

            $table->integer('client_id')->unsigned()->default(1);
            $table->foreign('client_id')->references('id')->on('clients');
            
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('code_verification', 30);
            $table->rememberToken();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
