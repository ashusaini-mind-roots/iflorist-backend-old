<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DateDim extends Model
{
    protected $table = 'dates_dim';

    static function findBy_($year, $day_of_week, $week_number)
    {
        $dateDim = DB::table('dates_dim')
            ->where('week_year',$year)
            ->where('day_of_week',$day_of_week)
            ->where('week_starting_monday',$week_number)
            ->first();
        return  $dateDim;

    }

    static function allDaysText()
    {
        $daysText = array('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');
        return $daysText;
    }
	
	static public function findDaysNumber($number, $year)
    {
        return $week = DB::table('dates_dim')
			->where('week_starting_monday',$number)
            ->where('year',$year)
            ->get();
    }
}
