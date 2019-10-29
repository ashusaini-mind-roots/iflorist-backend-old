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
            //->Join('stores','stores.id','=','store_week.store_id')
            //->Join('store_week','store_week.id','=','weekly_projection_percent_revenues.store_week_id')
            
        ->where('weekly_projection_percent_revenues.store_id', $store_id)
        ->where('weekly_projection_percent_revenues.year_proyection', $year)
        ->select('weekly_projection_percent_revenues.*'/*,'store_week.week_id'*/)
        ->get();

        $result = array();

        foreach($weeklyProjectionPercentRevenues as $w)
        {
            $week = DB::table('weeks')
            ->where('weeks.number', $w->week_number)
            ->where('weeks.year', $w->year_proyection)
            ->select('weeks.id')
            ->first();

            $store_week = DB::table('store_week')
            ->where('store_week.store_id', $w->store_id)
            ->where('store_week.week_id', $week->id)
            ->select('store_week.id')
            ->first();

            $dailyRevenues = DB::table('daily_revenues')
            ->Join('dates_dim','dates_dim.date','=','daily_revenues.dates_dim_date')
            ->where('daily_revenues.store_week_id', $store_week->id)
            ->select('dates_dim.*')
            ->get();

            $weeklyProjectionPercentRevenueReference = DB::table('weekly_projection_percent_revenues')
                ->where('weekly_projection_percent_revenues.week_number', $w->week_number)
                ->where('weekly_projection_percent_revenues.store_id', $w->store_id)
                ->where('weekly_projection_percent_revenues.year_proyection', $w->year_reference)
                ->select('weekly_projection_percent_revenues.*'/*,'store_week.week_id'*/)
                ->first();

            if(!$weeklyProjectionPercentRevenueReference)
            {
                $result = array();
                return  $result;
            }
            
            $row['id'] = $w->id;
            $row['amt_total'] = $w->amt_total;
            $row['reference_amt_total'] = $weeklyProjectionPercentRevenueReference->amt_total;
            $row['week'] = $dailyRevenues[0]->month.' '.$dailyRevenues[0]->month_day.' - '.$dailyRevenues[6]->month.' '.$dailyRevenues[6]->month_day;
            $row['adjust'] = $w->percent;
            
            $result[] = $row;
        }

        return  $result;
    }
}
