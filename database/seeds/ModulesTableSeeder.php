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
        Module::create(['name' => 'Sales','number' => 1, 'icono'=> 'default','action'=> '/sales']);
        Module::create(['name' => 'Cost of Fresh','number' => 2, 'icono'=> 'default','action'=> '/cost-of/fresh']);
        Module::create(['name' => 'Cost of Hard Goods','number' => 3, 'icono'=> 'default','action'=> '/cost-of/goods']);
        Module::create(['name' => 'Sheduler','number' => 4, 'icono'=> 'default','action'=> '/scheduler']);
        Module::create(['name' => 'Bloomview','number' => 5, 'icono'=> 'default','action'=> '#']);
        Module::create(['name' => 'Projections','number' => 6, 'icono'=> 'default','action'=> '/projections']);
    }
}
