<?php

use Illuminate\Database\Seeder;
use App\Models\Employee;

class EmployeeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Employee::create([
		    'name' => 'Admin Store',
            'category_id' => 1,
            'status_id' => 1,
            'work_man_comp_id' => 1,
            'user_id' => '2',
			'phone_number' => '58579632',
			'image' => 'default',
			'overtimeelegible' => 0,
			'hourlypayrate' => 10,
			'system_account' => 1,
			'year_pay' => 0,
			'active' => 1,
			'store_id' => 1,
		]);
		
		Employee::create([
		    'name' => 'Employee1',
            'category_id' => 1,
            'status_id' => 1,
            'work_man_comp_id' => 1,
            'user_id' => '5',
			'phone_number' => '75874658',
			'image' => 'default',
			'overtimeelegible' => 0,
			'hourlypayrate' => 10,
			'system_account' => 1,
			'year_pay' => 0,
			'active' => 1,
			'store_id' => 1,
		]);
    }
}
