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
        PlanModule::create(['plan_id' => 1,'module_id' => 1]);
        PlanModule::create(['plan_id' => 1,'module_id' => 2]);

        PlanModule::create(['plan_id' => 2,'module_id' => 3]);
        PlanModule::create(['plan_id' => 2,'module_id' => 4]);
        PlanModule::create(['plan_id' => 2,'module_id' => 5]);
        
        PlanModule::create(['plan_id' => 3,'module_id' => 6]);
		PlanModule::create(['plan_id' => 3,'module_id' => 7]);
    }
}
