<?php
namespace App\Http\Controllers;

use Faker\Provider\cs_CZ\DateTime;
use Illuminate\Http\Request;

use App\Models\Employee;
use App\Models\StoreWeek;
Use App\Models\EmployeeStoreWeek;
Use App\Models\Category;
Use App\Models\Schedule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ScheduleController extends Controller
{
    public function schedule_week($store_id,/*$year,*/$week_id)
    {
        $store_week_id = StoreWeek::storeWeekId($store_id,$week_id);
        $employee_store_week = EmployeeStoreWeek::findByStoreWeekId($store_week_id);
        $employee_store_week_id = -1;
        if($employee_store_week)
            $employee_store_week_id = $employee_store_week->id;
//        $schedules = Schedule::findByEmployeeStoreWeekId($employee_store_week->id);

        $categories = Category::all();
        $response = [];

        foreach ($categories as $category) {
            $employees = Employee::findByCategoryStore($category->id,$store_id);
            $employees_response = [];//employees de esta categoria
            foreach ($employees as $employee) {
                $employees_response[] = [
                    'name' => $employee->name,
                    'schedule_days' => Schedule::findByEmployeeAndStoreWeekIds($employee->id,$store_week_id),//los 7 schedules days de este employee
                    'employee_store_week_id' => $employee_store_week->id,
                ];
            }
            $response[] = ['category_name' => $category->name,'employees' => $employees_response];
        }

        return response()->json(['categories_schedules' => $response,'employee_store_week_id'=>$employee_store_week_id], 200);
    }

    public function update(Request $request)
    {
        $employee_store_week = $request->employee_store_week;
        $schedule_days = json_decode($request->schedule_days);

        if(is_array($schedule_days))
        {
           foreach ($schedule_days as $sche)
           {
               if($request->time_in && $request->time_out && $request->break_time)
               {
                   if($sche->id==-1)
                   {
                       $chedule = new Schedule();
                       $chedule->employee_store_week_id =$employee_store_week;
                       $chedule->time_in = Carbon::parse($request->time_in)->format('Y-m-d H:i:s');
                       $chedule->time_out = Carbon::parse($request->time_out)->format('Y-m-d H:i:s');
                       $chedule->break_time = $sche->break_time;
                       $chedule->dates_dim_date = date('Y-m-d');
                       $chedule->save();
                   }
                   else
                   {
                       $chedule = Schedule::findOrFail($sche->id);
                       $chedule->employee_store_week_id =$employee_store_week;
                       $chedule->time_in = Carbon::parse($request->time_in)->format('Y-m-d H:i:s');
                       $chedule->time_out = Carbon::parse($request->time_out)->format('Y-m-d H:i:s');
                       $chedule->break_time = $sche->break_time;
                       $chedule->dates_dim_date = date('Y-m-d');
                       $chedule->update();
                   }
               }

            }

            return response()->json(['status' => 'success'], 200);
        }

        return response()->json([
            'status' => 'error',
            'errors' => 'Schedule array invalid'
        ], 422);
    }
}
