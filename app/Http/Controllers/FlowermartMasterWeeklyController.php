<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Week;
use App\Models\DailyRevenue;
use App\Models\Invoice;

class FlowermartMasterWeeklyController extends Controller
{
    public function FlowermartMasterWeeklyOfFresh($store_id,$year)
    {
        $weeks = Week::where('year',$year)->get();

        $FlowermartMasterWeeklyOfFresh = array();

        foreach ($weeks as $w)
        {
            $day = DailyRevenue::lastDayWeek($store_id,$w->id);

            $arrayDatos = array(
                'week_ending' => $day->month.'-'.$day->month_day,
                'actual_weekly_revenue' => number_format((float)DailyRevenue::totalAmtWeek($store_id,$w->id),2,'.',''),
                'weekly_cog_total' => number_format((float)Invoice::total($store_id,$w->id),2,'.','')
            );

            $FlowermartMasterWeeklyOfFresh [] = $arrayDatos;
        }

        return response()->json(['flowermar_master_weekly_of_fresh' => $FlowermartMasterWeeklyOfFresh ], 200);
    }
}
