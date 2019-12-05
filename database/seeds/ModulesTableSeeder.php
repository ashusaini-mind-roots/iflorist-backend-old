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
        Module::create(['name' => 'Sales','number' => 1, 'icono'=> 'sales-icon','action'=> '/sales']);
        Module::create(['name' => 'Cost of Fresh','number' => 2, 'icono'=> 'costoffresh-icon','action'=> '/cost-of/fresh']);
        Module::create(['name' => 'Cost of Hard Goods','number' => 3, 'icono'=> 'costofgoods-icon','action'=> '/cost-of/goods']);
        Module::create(['name' => 'Sheduler','number' => 4, 'icono'=> 'scheduler-icon','action'=> '/scheduler']);
        Module::create(['name' => 'Bloomview','number' => 5, 'icono'=> 'scheduler-icon','action'=> '#']);
        Module::create(['name' => 'Projections','number' => 6, 'icono'=> 'scheduler-icon','action'=> '/projections']);
    }
}
