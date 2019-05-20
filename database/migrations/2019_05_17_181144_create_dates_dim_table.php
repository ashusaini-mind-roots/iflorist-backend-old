<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDatesDimTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dates_dim', function (Blueprint $table) {
            $table->date('date')->primary();
            $table->bigInteger('timestamp');
            $table->char('weekend',10);
            $table->char('day_of_week',10);
            $table->char('month',10);
            $table->integer('month_day');
            $table->year('year');
            $table->char('week_starting_monday',2);
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
        Schema::dropIfExists('dates_dim');
    }
}
