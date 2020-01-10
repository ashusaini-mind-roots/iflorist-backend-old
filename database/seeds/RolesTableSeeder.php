<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Role::truncate();
		Role::create(['name' => 'ROOT']);
        Role::create(['name' => 'EMPLOYEE']);
        Role::create(['name' => 'APPUSER']);
		Role::create(['name' => 'COMPANYADMIN']);
		Role::create(['name' => 'STOREMANAGER']);
        Role::create(['name' => 'COMPANYEMPLOYEE']);
    }
}
