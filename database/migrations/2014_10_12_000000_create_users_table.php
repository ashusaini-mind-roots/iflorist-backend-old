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
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->integer('role_id')->default(1);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            $table->boolean('activated_account')->nullable();
            $table->string('activation_code',16)->nullable();
            $table->datetime('activation_code_expired_date')->nullable();
            $table->rememberToken();
            $table->timestamps();

           // $table->foreign('role_id')->references('id')->on('roles');
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
