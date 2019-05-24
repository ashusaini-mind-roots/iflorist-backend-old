<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Week;
use App\Models\DailyRevenue;
use App\Models\Invoice;
use App\Models\WeeklyProjectionPercentRevenues;
use App\Models\StoreWeek;
use App\Models\WeeklyProjectionPercentCosts;

class MasterOverviewWeeklyController extends Controller
{
    public function MasterOverviewWeeklyOfFresh($store_id,$year)
    {
        $weeks = Week::where('year',$year)->get();

        $FlowermartMasterWeeklyOfFresh = array();

        foreach ($weeks as $w)
        {
            $day = DailyRevenue::lastDayWeek($store_id,$w->id);

            $actual_weekly_revenue = DailyRevenue::totalAmtWeek($store_id,$w->id);
            $weekly_cog_total = Invoice::total($store_id,$w->id);

            if($weekly_cog_total==0)
            {
                $total = 0;
            }
            else
            {
                $total = $weekly_cog_total*100/$actual_weekly_revenue;
            }

            $arrayDatos = array(
                'week_id' => $w->id,
                'week_ending' => $day->month.'-'.$day->month_day,
                'actual_weekly_revenue' => number_format((float)$actual_weekly_revenue,2,'.',''),
                'weekly_cog_total' => number_format((float)$weekly_cog_total,2,'.',''),
                'target' => WeeklyProjectionPercentCosts::target($store_id,$w->id),
                'actual' => number_format((float)$total,2,'.',''),
                'difference' => number_format((int)WeeklyProjectionPercentCosts::target($store_id,$w->id) - $total,0,'.','')
            );

            $FlowermartMasterWeeklyOfFresh [] = $arrayDatos;
        }

        return response()->json(['flowermar_master_weekly_of_fresh' => $FlowermartMasterWeeklyOfFresh ], 200);
    }
}
