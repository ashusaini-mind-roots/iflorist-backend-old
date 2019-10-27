<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Model;

class WeeklyProjectionPercentRevenues extends Model
{
    protected $table = 'weekly_projection_percent_revenues';

    static function getWeeklyProjectionPercentRevenues($store_id,$year)
    {
        $weeklyProjectionPercentRevenues = DB::table('weekly_projection_percent_revenues')
            ->Join('store_week','store_week.id','=','weekly_projection_percent_revenues.store_week_id')
            ->Join('stores','stores.id','=','store_week.store_id')
            ->where('stores.id', $store_id)
            ->where('weekly_projection_percent_revenues.year_proyection', $year)
            ->select('weekly_projection_percent_revenues.*','store_week.week_id')
            ->get();

        $result = array();

        foreach($weeklyProjectionPercentRevenues as $w)
        {
            $dailyRevenues = DB::table('daily_revenues')
            ->Join('dates_dim','dates_dim.date','=','daily_revenues.dates_dim_date')
            ->where('daily_revenues.store_week_id', $w->store_week_id)
            ->select('dates_dim.*')
            ->get();

            $row['amt_total'] = $w->amt_total;
            $row['week'] = $dailyRevenues[0]->month.' '.$dailyRevenues[0]->month_day.' - '.$dailyRevenues[6]->month.' '.$dailyRevenues[6]->month_day;
            $row['adjust'] = $w->percent;
            
            $result[] = $row;
        }

        return  $weeklyProjectionPercentRevenues;
    }
}
