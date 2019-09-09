<?php

use Illuminate\Database\Seeder;
use App\Models\PlanModule;

class PlanModuleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PlanModule::create(['plan_id' => 4,'module_id' => 5]);
        PlanModule::create(['plan_id' => 4,'module_id' => 6]);

        PlanModule::create(['plan_id' => 5,'module_id' => 7]);
        PlanModule::create(['plan_id' => 5,'module_id' => 8]);
        
        PlanModule::create(['plan_id' => 6,'module_id' => 9]);
    }
}
