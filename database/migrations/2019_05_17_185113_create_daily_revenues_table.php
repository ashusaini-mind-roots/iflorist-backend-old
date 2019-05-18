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
            $table->integer('store_week_id')->unsigned();
            $table->integer('dates_dim_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->decimal('amt',10,2);
            $table->dateTime('entered_date');
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
        Schema::dropIfExists('daily_revenue');
    }
}
