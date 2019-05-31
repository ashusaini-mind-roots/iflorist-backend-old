<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EmployeeStoreWeek extends Model
{
    protected $table = 'employee_store_week';

    static public function findByStoreWeekId($storeWeekId)
    {
        return $employee_store_week = DB::table('employee_store_week')
            ->where('store_week_id',$storeWeekId)
            ->first();
    }
}
