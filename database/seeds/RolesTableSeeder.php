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
		Role::create(['name' => 'Root']);
        Role::create(['name' => 'Empleado']);
        Role::create(['name' => 'AppAdmin']);
		Role::create(['name' => 'Empresa']);
		Role::create(['name' => 'AdminStore']);
    }
}
