<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->increments('idusers');
            $table->string('name');
            $table->string('last_name');
            $table->string('email');
            $table->string('password');
            $table->string('state');
            $table->integer('rol_idrol');
            $table->integer('company_idcompany');
            $table->string('id')->unique();
            $table->integer('type');
            $table->string('token_fir');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    // $table->increments('idusers');
    // $table->string('name');
    // $table->string('last_name');
    // $table->string('email');
    // $table->string('password');
    // $table->string('state');
    // $table->integer('rol_idrol');
    // $table->integer('company_idcompany');
    // $table->string('id')->unique();
    // $table->integer('type');
    // $table->string('token_fir');
    // $table->rememberToken();
    // $table->timestamps();
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
