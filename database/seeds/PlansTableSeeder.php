<?php

use Illuminate\Database\Seeder;
use App\Models\Plan;


class PlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Plan::create(['name' => 'Plan 1','cost' => 119.1,'special' => 0]);
        Plan::create(['name' => 'Plan 2','cost' => 215.1,'special' => 0]);
        Plan::create(['name' => 'Plan 3','cost' => 309.0,'special' => 1]);
    }
}
