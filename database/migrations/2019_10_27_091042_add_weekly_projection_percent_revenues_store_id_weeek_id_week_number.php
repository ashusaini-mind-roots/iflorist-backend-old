<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWeeklyProjectionPercentRevenuesStoreIdWeeekIdWeekNumber extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('weekly_projection_percent_revenues', function (Blueprint $table) {
            $table->bigInteger('store_id')->unsigned();
            $table->bigInteger('week_id')->unsigned();
            $table->char('week_number',2);

            $table->foreign('store_id')->references('id')->on('stores');
            $table->foreign('week_id')->references('id')->on('weeks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('weekly_projection_percent_revenues');
    }
}
