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
        Schema::create('dates_dimdiff_projection_percent', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('store_week_id')->unsigned();
            $table->year('year_proyection');
            $table->year('year_reference');
            $table->decimal('percent',10,2);
            
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
        Schema::dropIfExists('dates_dimdiff_projection_percent');
    }
}
