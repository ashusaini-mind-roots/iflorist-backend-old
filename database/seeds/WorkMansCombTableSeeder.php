<?php

use Illuminate\Database\Seeder;
use App\Models\WorkManComp;

class WorkMansCombTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        WorkManComp::create(['name' => 'Florist & Driver','code' => '8001','rate' => '4.18']);
        WorkManComp::create(['name' => 'Sales & Clerical','code' => '8810','rate' => '0.18']);
    }
}
