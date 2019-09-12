<?php

use Illuminate\Database\Seeder;
use App\Models\Module;

class ModulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Module::create(['name' => 'Module 1']);
        Module::create(['name' => 'Module 2']);
        Module::create(['name' => 'Module 3']);
        Module::create(['name' => 'Module 4']);
        Module::create(['name' => 'Module 5']);
    }
}
