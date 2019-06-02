<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Employee;
use App\Models\StoreWeek;
Use App\Models\EmployeeStoreWeek;
Use App\Models\Category;
Use App\Models\Schedule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    public function schedule_week($store_id,/*$year,*/$week_id)
    {
        $store_week_id = StoreWeek::storeWeekId($store_id,$week_id);
//        $employee_store_week = EmployeeStoreWeek::findByStoreWeekId($store_week_id);
//        $schedules = Schedule::findByEmployeeStoreWeekId($employee_store_week->id);

        $categories = Category::all();
        $response = [];

        foreach ($categories as $category) {
            $employees = Employee::findByCategoryStore($category->id,$store_id);
            $employees_response = [];//employees de esta categoria
            foreach ($employees as $employee) {
                $employees_response[] = [
                    'name' => $employee->name,
                    'schedule_days' => Schedule::findByEmployeeAndStoreWeekIds($employee->id,$store_week_id)//los 7 schedules days de este employee
                ];
            }
            $response[] = ['category_name' => $category->name,'employees' => $employees_response];
        }

        return response()->json(['categories_schedules' => $response], 200);
    }
}
