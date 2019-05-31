<?php

namespace App\Models;

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
}
