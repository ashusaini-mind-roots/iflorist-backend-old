<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Model;
use App\Models\DateDim;

class WeeklyProjectionPercentRevenues extends Model
{
    protected $table = 'weekly_projection_percent_revenues';

    static function getByStoreIdYearWeekNumber($store_id,$year,$week_number){
        $weeklyProjectionPercentRevenues = DB::table('weekly_projection_percent_revenues')
            //->Join('stores','stores.id','=','store_week.store_id')
            //->Join('store_week','store_week.id','=','weekly_projection_percent_revenues.store_week_id')

            ->where('weekly_projection_percent_revenues.store_id', $store_id)
            ->where('weekly_projection_percent_revenues.year_proyection', $year)
            ->where('weekly_projection_percent_revenues.week_number', $week_number)
            ->select('weekly_projection_percent_revenues.*'/*,'store_week.week_id'*/)
            ->get();
        return $weeklyProjectionPercentRevenues;
    }

    static function getByYearProyectionAndWeekNumber($year_proyection, $week_number){
        $weeklyProjectionPercentRevenues = DB::table('weekly_projection_percent_revenues')
        ->where('weekly_projection_percent_revenues.year_proyection', $year_proyection)
            ->where('weekly_projection_percent_revenues.week_number', $week_number)
            ->first();
        return $weeklyProjectionPercentRevenues;
    }

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
            /*$week = DB::table('weeks')
            ->where('weeks.number', $w->week_number)
            ->where('weeks.year', $w->year_proyection)
            ->select('weeks.id')
            ->first();

            $store_week = DB::table('store_week')
            ->where('store_week.store_id', $w->store_id)
            ->where('store_week.week_id', $week->id)
            ->select('store_week.id')
            ->first();*/

            /*$dailyRevenues = DB::table('daily_revenues')
            ->Join('dates_dim','dates_dim.date','=','daily_revenues.dates_dim_date')
            ->where('daily_revenues.store_week_id', $store_week->id)
            ->select('dates_dim.*')
            ->get();*/

            $weeklyProjectionPercentRevenueReference = DB::table('weekly_projection_percent_revenues')
                ->where('weekly_projection_percent_revenues.week_number', $w->week_number)
                ->where('weekly_projection_percent_revenues.store_id', $w->store_id)
                ->where('weekly_projection_percent_revenues.year_proyection', $w->year_reference)
                ->select('weekly_projection_percent_revenues.*'/*,'store_week.week_id'*/)
                ->first();

            $amtTotalReference = 0;

            if($weeklyProjectionPercentRevenueReference)
            {
                $amtTotalReference = $weeklyProjectionPercentRevenueReference->amt_total;
            }

            $dateDims = DateDim::where('week_starting_monday',$w->week_number)->where('year',$w->year_proyection)->get();
            
            $row['id'] = $w->id;
            $row['amt_total'] = $w->amt_total;
            $row['reference_amt_total'] = $amtTotalReference;
            $row['week'] = $dateDims[0]->month_day.' '.$dateDims[0]->month.' - '.$dateDims[6]->month_day.' '.$dateDims[6]->month;
            $row['adjust'] = $w->percent;
            
            $result[] = $row;
        }

        return  $result;
    }
}
