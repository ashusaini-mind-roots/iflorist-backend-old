<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiffProjectionPercentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diff_projection_percent', function (Blueprint $table) {
            $table->bigIncrements('id');
            //$table->bigInteger('store_week_id')->unsigned();;
            $table->year('year_proyection');
            $table->year('year_reference')->nullable();
//            $table->decimal('amt_total',10,2)->default(0.00);
            $table->decimal('percent',10,2)->default(00.0);
            
            $table->timestamps();

            //$table->foreign('store_week_id')->references('id')->on('store_week');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('diff_projection_percent');
    }
}
