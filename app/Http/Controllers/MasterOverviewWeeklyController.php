<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Week;
use App\Models\DailyRevenue;
use App\Models\Invoice;
use App\Models\WeeklyProjectionPercentRevenues;
use App\Models\StoreWeek;
use App\Models\WeeklyProjectionPercentCosts;
use League\Flysystem\Exception;

class MasterOverviewWeeklyController extends Controller
{
    public function MasterOverviewWeeklyOfFresh($store_id,$year)
    {
        $weeks = Week::where('year',$year)->get();

        $FlowermartMasterWeeklyOfFresh = array();

        foreach ($weeks as $w)
        {

            $responseValue = 0.00;
            $amtTotal = 0.00;
            $week_number = -1;

            $store_week_id = StoreWeek::storeWeekId($store_id,$w->id);

            $wppRevenues = WeeklyProjectionPercentRevenues::where('store_week_id',$store_week_id)->first();
            $year_reference = $wppRevenues->year_reference;
            $percent = $wppRevenues->percent;

            $week_number = week::find($w->id)->number;

            //$week_reference = Week::findByNumberYear($week_number, $year_reference);

            $week_reference_id = Week::findByNumberYear($week_number, $year_reference)->id;

            $amtTotal = DailyRevenue::totalAmtWeek($store_id, $week_reference_id);

            $responseValue = $amtTotal - ($percent * $amtTotal / 100);



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
                'projected_weekly_revenue' => number_format((float)$responseValue,2,'.',''),
                'actual_weekly_revenue' => number_format((float)$actual_weekly_revenue,2,'.',''),
                'weekly_cog_total' => number_format((float)$weekly_cog_total,2,'.',''),
                'target' => number_format((float)WeeklyProjectionPercentCosts::target($store_id,$w->id),2,'.',''),
                'actual' => number_format((float)$total,2,'.',''),
                'difference' => number_format((float)WeeklyProjectionPercentCosts::target($store_id,$w->id) - $total,2,'.','')
            );

            $master_overview_weekly [] = $arrayDatos;
        }

        return response()->json(['master_overview_weekly' => $master_overview_weekly ], 200);
    }
}
