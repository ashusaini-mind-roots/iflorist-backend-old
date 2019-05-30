<?php

use Illuminate\Database\Seeder;
use App\Models\TaxPercentCalculator;

class TaxPercentCalculatorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TaxPercentCalculator::create(['sui' => '0.10','futa' => '1.0','social_security' => '6.20','medicare' => '1.45']);
    }
}
