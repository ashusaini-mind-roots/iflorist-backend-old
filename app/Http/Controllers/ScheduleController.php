<?php
namespace App\Http\Controllers;

use Faker\Provider\cs_CZ\DateTime;
use Illuminate\Http\Request;

use App\Models\Employee;
use App\Models\StoreWeek;
Use App\Models\EmployeeStoreWeek;
Use App\Models\Category;
Use App\Models\Schedule;
Use App\Models\Week;
Use App\Models\DateDim;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ScheduleController extends Controller
{
    public function schedule_week(Request $request, $store_id, $week_id)
    {
		$store_week_id = StoreWeek::storeWeekId($store_id,$week_id);
        //$employee_store_week = EmployeeStoreWeek::findByStoreWeekId($store_week_id);
        $employee_store_week_id = -1;
        // if($employee_store_week)
        //     $employee_store_week_id = $employee_store_week->id;
//        $schedules = Schedule::findByEmployeeStoreWeekId($employee_store_week->id);

        $week = week::find($week_id);
        if($week)
            $firsDayMonday = DateDim::findBy_($week->year,'Monday',$week->number);

        $categories = Category::all();
        $response = [];
		foreach ($categories as $category) {
			$roles = $request->auth_roles_parse;
			if(in_array("COMPANYADMIN",$roles) || in_array("STOREMANAGER",$roles) )
			{
				$employees = Employee::findByCategoryStore($category->id,$store_id);
			}
			else if(in_array("EMPLOYEE",$roles))
			{
				$employees = Employee::findByCategoryUser($category->id,auth()->user()->id);
			}
            
            $employees_response = [];//employees at this category
            $probando = [];
            if($category->id == 2)
                $probando = $employees;
            foreach ($employees as $employee) {
                $schedules = Schedule::findByEmployeeAndStoreWeekIds($employee->id,$store_week_id);//those are 7 days of this employee;

                $employee_store_week = EmployeeStoreWeek::findByEmployeeANDStoreWeekId($employee->id,$store_week_id);
                if($employee_store_week){
                    $employee_store_week_id = $employee_store_week->id;
                    $to_send = $this->conformSchedulesToSend($schedules,$employee_store_week_id );
                    $schedules_to_send = $to_send['schedules_to_send'];
                    $employees_response[] = [
                        'name' => $employee->name,
                        'employee_id' => $employee->id,
                        'id' => ''.$employee->id . "" . $category->id,
                        'active' =>$employee->active,
                        'schedule_days' => $schedules_to_send,
                        'employee_store_week_id' => $employee_store_week_id,
                        'total_minutes_at_week' => $to_send['total_minutes'],
                        'hourly_pay_rate' => $employee->hourlypayrate,
                        'over_time_elegible' => $employee->overtimeelegible,
                        'category_name' => $category->name,
                        'category_id' => $category->id,
                        'employees_array_length_at_this_category' => count($employees),
                    ];
                }
            }


            $response[] = ['probando'=>$probando,'id' => $category->id, 'category_name' => $category->name,'employees' => $employees_response,
//'daymonday'=>$date->addDays(1)
//                'emplotest'=>$employees,
//                'scheduletest' =>$schedules,
//                'employeestoreweektest' => $employee_store_week
            ];
        }

		$dates_of_week = [];
        $date = Carbon::createFromFormat('Y-m-d', $firsDayMonday->date);
        $dates_of_week[] = $date->format('m/d/Y');
        for($i = 0 ; $i < 6 ; $i++){
            $added = $date->addDay(1);
            $dates_of_week[] = $added->format('m/d/Y');
        }

        return response()->json(['categories_schedules' => $response,'dates_of_week'=>$dates_of_week], 200);
    }

    private function conformSchedulesToSend($schedulesFromDatabase, $employee_store_week_id)
    {
        $schedules_to_send = [
            ['id' => -1, 'employee_store_week_id' => $employee_store_week_id, 'day_of_week' => 'Monday'],
            ['id' => -1, 'employee_store_week_id' => $employee_store_week_id, 'day_of_week' => 'Tuesday'],
            ['id' => -1, 'employee_store_week_id' => $employee_store_week_id, 'day_of_week' => 'Wednesday'],
            ['id' => -1, 'employee_store_week_id' => $employee_store_week_id, 'day_of_week' => 'Thursday'],
            ['id' => -1, 'employee_store_week_id' => $employee_store_week_id, 'day_of_week' => 'Friday'],
            ['id' => -1, 'employee_store_week_id' => $employee_store_week_id, 'day_of_week' => 'Saturday'],
            ['id' => -1, 'employee_store_week_id' => $employee_store_week_id, 'day_of_week' => 'Sunday'],
        ];

        $total_minutes = 0.00;
        for($i = 0 ; $i < count($schedulesFromDatabase) ; $i++){
            if($schedulesFromDatabase[$i]->day_of_week == "Monday")
                $schedules_to_send[0] = $schedulesFromDatabase[$i];
            elseif ($schedulesFromDatabase[$i]->day_of_week == "Tuesday")
                $schedules_to_send[1] = $schedulesFromDatabase[$i];
            elseif ($schedulesFromDatabase[$i]->day_of_week == "Wednesday")
                $schedules_to_send[2] = $schedulesFromDatabase[$i];
            elseif ($schedulesFromDatabase[$i]->day_of_week == "Thursday")
                $schedules_to_send[3] = $schedulesFromDatabase[$i];
            elseif ($schedulesFromDatabase[$i]->day_of_week == "Friday")
                $schedules_to_send[4] = $schedulesFromDatabase[$i];
            elseif ($schedulesFromDatabase[$i]->day_of_week == "Saturday")
                $schedules_to_send[5] = $schedulesFromDatabase[$i];
            elseif ($schedulesFromDatabase[$i]->day_of_week == "Sunday")
                $schedules_to_send[6] = $schedulesFromDatabase[$i];

            $total_minutes += Schedule::scheduleDiffHours($schedulesFromDatabase[$i]);//this function actually get minutes, not hours
        }
        return ['schedules_to_send' => $schedules_to_send, 'total_minutes' => $total_minutes];
    }
	
	public function seven_days_number($week_id)
	{
		$week = Week::find($week_id);
		$daysNumber = DateDim::findDaysNumber($week->number,$week->year);
		return response()->json(['status' => 'success','days_number'=>$daysNumber], 200);
	}

    public function updateoradd(Request $request)
    {
        $schedule_days = json_decode($request->schedule_days);
        $week_number = week::find($request->week_id)->number;
        $year = $request->year;
        $employee_id = $request->employee_id;

        $arrayre = [];

        $temp_new = [];
        if(is_array($schedule_days))
        {
            foreach ($schedule_days as $sche)
            {
                if(isset($sche->time_in) && isset($sche->time_out) && isset($sche->employee_store_week_id))
                {
                    if($sche->id==-1)
                    {
                        $chedule = new Schedule();
                        $chedule->employee_store_week_id = $sche->employee_store_week_id;
                        $chedule->time_in = Carbon::parse($sche->time_in)->format('Y-m-d H:i:s');
                        $chedule->time_out = Carbon::parse($sche->time_out)->format('Y-m-d H:i:s');
                        $chedule->break_time = !isset($sche->break_time) ? 0 : $sche->break_time;
                        $dimdate = DateDim::findBy_($year, $sche->day_of_week, $week_number);
                        $arrayre[] =$dimdate;
                        $chedule->dates_dim_date = $dimdate->date;
                        //$chedule->dates_dim_date = date('Y-m-d');
                        $chedule->save();
                        $sche->id = $chedule->id;
                        $sche->dates_dim_date = $dimdate->date;
                        $temp_new[] = $sche;
                    }
                    else
                    {
                        $chedule = Schedule::findOrFail($sche->id);
                        $chedule->employee_store_week_id = $sche->employee_store_week_id;
                        $chedule->time_in = Carbon::parse($sche->time_in)->format('Y-m-d H:i:s');
                        $chedule->time_out = Carbon::parse($sche->time_out)->format('Y-m-d H:i:s');
                        $chedule->break_time = !isset($sche->break_time) ? $chedule->break_time : $sche->break_time;
                        $dimdate = DateDim::findBy_($year, $sche->day_of_week, $week_number);
                        $arrayre[] = $dimdate;
                        $chedule->dates_dim_date =  $dimdate->date;
                        //$chedule->dates_dim_date = date('Y-m-d');
                        $chedule->update();
                    }
                }
            }
            return response()->json(['status' => 'success','weeknumber'=>$week_number, "year"=>$year,'days_information'=>$arrayre,'schedules_added'=>$temp_new, 'employee_id'=>$employee_id], 200);
        }

        return response()->json([
            'status' => 'error',
            'errors' => 'Schedule array invalid'
        ], 422);
    }


    public function categoryEmployeeList(Request $request,$store_id){
        $categories_response = [];
        $categories = Category::all();

//        $employees = [];
        foreach ($categories as $category) {
            $employees = [];
            $roles = $request->auth_roles_parse;
            if (in_array("COMPANYADMIN", $roles) || in_array("STOREMANAGER", $roles)) {
                $employees = Employee::findByCategoryStore($category->id, $store_id);
            } else if (in_array("EMPLOYEE", $roles)) {
                $employees = Employee::findByCategoryUser($category->id, auth()->user()->id);
            }
            $categories_response[] = ['id'=>$category->id, 'name' => $category->name, 'employees' => $employees];
        }
        return response()->json(['categories_employees' => $categories_response], 200);
    }

}
