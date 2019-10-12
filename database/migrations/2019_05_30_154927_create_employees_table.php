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
            $table->bigInteger('work_man_comp_id')->unsigned();
            $table->bigInteger('user_id')->unsigned()->nullable(true);
            $table->string('name');
            $table->boolean('overtimeelegible');
            $table->decimal('hourlypayrate',4,2);
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories');
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
