<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectionPercentage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projection_percentage', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('store_week_id')->unsigned();
            $table->decimal('projection_percentage',5,2);
            $table->timestamps();

            $table->foreign('store_week_id')->references('id')->on('store_week');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projection_percentage');
    }
}
