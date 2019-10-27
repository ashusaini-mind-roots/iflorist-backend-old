<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDailyRevenuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_revenues', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('store_week_id')->unsigned();
            $table->date('dates_dim_date');
            $table->integer('user_id')->unsigned();
            $table->decimal('merchandise',10,2);
            $table->decimal('wire',10,2);
            $table->decimal('delivery',10,2);
            $table->dateTime('entered_date');
            $table->timestamps();

            $table->foreign('store_week_id')->references('id')->on('store_week');
            $table->foreign('dates_dim_date')->references('date')->on('dates_dim');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('daily_revenue');
    }
}
