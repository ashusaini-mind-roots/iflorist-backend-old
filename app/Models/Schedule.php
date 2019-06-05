<?php

namespace App\Models;

use Faker\Provider\cs_CZ\DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Schedule extends Model
{
    protected $table = 'schedules';

    static public function findByEmployeeStoreWeekId($employee_store_week_Id)
    {
        return $employee_store_week = DB::table('schedules')
            ->where('employee_store_week_id',$employee_store_week_Id)
            ->get();
    }

    static public function findByEmployeeAndStoreWeekIds($employee_id,$store_week_id)
    {
        $schedules_return = DB::table('employees')
            ->Join('employee_store_week','employee_store_week.employee_id','=','employees.id')
            ->Join('schedules','schedules.employee_store_week_id','=','employee_store_week.id')
            ->Join('dates_dim','dates_dim.date','=','schedules.dates_dim_date')
            ->select('schedules.*','dates_dim.day_of_week','dates_dim.month','dates_dim.month_day')
            ->where('employees.id',$employee_id)
            ->where('employee_store_week.store_week_id',$store_week_id)
            ->orderBy('schedules.dates_dim_date','asc')
            ->get();

        return $schedules_return;
    }

    static public function findScheduleByStoreWeekAndYear($store_week_id,$year)
    {
        $schedules = DB::table('schedules')
            ->Join('employee_store_week','employee_store_week.id','=','schedules.employee_store_week_id')
            ->Join('store_week','store_week.id','=','employee_store_week.store_week_id')
            ->Join('employees','employees.id','=','employee_store_week.employee_id')
            ->Join('categories','categories.id','=','employees.category_id')
            ->Join('dates_dim','dates_dim.date','=','schedules.dates_dim_date')
            ->where('dates_dim.year',$year)
            ->where('store_week.id',$store_week_id)
            ->where('categories.omit_col',0)
            ->get();

        return $schedules;
    }

    static public function scheduleDiffHours($schedule_id)
    {
        $chedule = DB::table('schedules')
            ->where('schedules.id',$schedule_id)->first();

        $diff_seg = ((strtotime($chedule->time_out)-strtotime($chedule->time_in))/60)-$chedule->break_time;

        return number_format((float)$diff_seg/60,'2','.','');
    }
}
