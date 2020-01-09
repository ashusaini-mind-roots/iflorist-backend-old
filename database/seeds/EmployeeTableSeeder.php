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
			'phone_number' => '45874',
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
