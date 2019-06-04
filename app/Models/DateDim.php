<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DateDim extends Model
{
    protected $table = 'dates_dim';

    static function findBy_($week_year, $day_of_week, $week_number)
    {
        $dateDim = DB::table('dates_dim')
            ->where('week_year',$week_year)
            ->where('day_of_week',$day_of_week)
            ->where('week_starting_monday',$week_number)
            ->first();
        return  $dateDim;
    }
}
