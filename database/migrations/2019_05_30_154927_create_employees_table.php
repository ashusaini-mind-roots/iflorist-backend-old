<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('category_id')->unsigned();
            $table->bigInteger('status_id')->unsigned()->nullable(true);
            $table->bigInteger('work_man_comp_id')->unsigned();
            $table->bigInteger('user_id')->unsigned()->nullable(true);
            $table->string('name');
            $table->string('phone_number');
            $table->string('image');
            $table->boolean('overtimeelegible');
            $table->decimal('hourlypayrate',10,2);
            $table->boolean('system_account');
            $table->boolean('year_pay');
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('status_id')->references('id')->on('status');
            $table->foreign('work_man_comp_id')->references('id')->on('work_mans_comp');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
