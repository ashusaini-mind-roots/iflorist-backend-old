<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaxPercentCalculatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tax_percent_calculators', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('sui',3,1);
            $table->decimal('futa',3,1);
            $table->decimal('social_security',3,1);
            $table->decimal('medicare',3,1);
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
        Schema::dropIfExists('tax_percent_calculators');
    }
}
