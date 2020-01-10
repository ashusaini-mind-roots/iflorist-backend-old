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
        Module::create(['name' => 'Dashboard','number' => 1, 'icono'=> 'dashboard-icon','action'=> '/home', 'roles'=>'ROOT,COMPANYADMIN,STOREMANAGER']);
        Module::create(['name' => 'Sales','number' => 2, 'icono'=> 'sales-icon','action'=> '/sales', 'roles'=>'ROOT,COMPANYADMIN,STOREMANAGER']);
        Module::create(['name' => 'Cost of Fresh','number' => 3, 'icono'=> 'costoffresh-icon','action'=> '/cost-of/fresh', 'roles'=>'ROOT,COMPANYADMIN,STOREMANAGER']);
        Module::create(['name' => 'Cost of Hard Goods','number' => 4, 'icono'=> 'costofgoods-icon','action'=> '/cost-of/goods', 'roles'=>'ROOT,COMPANYADMIN']);
        Module::create(['name' => 'Sheduler','number' => 5, 'icono'=> 'scheduler-icon','action'=> '/scheduler', 'roles'=>'ROOT,COMPANYADMIN,EMPLOYEE']);
        Module::create(['name' => 'Bloomview','number' => 6, 'icono'=> 'bloomview-icon','action'=> '#', 'roles'=>'ROOT,COMPANYADMIN']);
        Module::create(['name' => 'Projections','number' => 7, 'icono'=> 'projections-icon','action'=> '/projections', 'roles'=>'ROOT,COMPANYADMIN']);
    }
}
