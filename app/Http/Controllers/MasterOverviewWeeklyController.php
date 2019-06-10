<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Week;
use App\Models\DailyRevenue;
use App\Models\Invoice;
use App\Models\WeeklyProjectionPercentRevenues;
use App\Models\StoreWeek;
use App\Models\WeeklyProjectionPercentCosts;
use Illuminate\Support\Carbon;
use App\Models\TargetPercentage;
use League\Flysystem\Exception;
use App\Models\Schedule;
use App\Models\EmployeeStoreWeek;

class MasterOverviewWeeklyController extends Controller
{
    public function getDataStoreWeekYear($store_id, $week_nbr, $year_reference_selected)
    {
        try {
            $week_id = Week::findByNumberYear($week_nbr, $year_reference_selected)->id;
            $total = DailyRevenue::totalAmtWeek($store_id, $week_id);
            return response()->json(['total'=>$total]);
        } catch (\Exception $e) {
            return response()->json($e, 500);
        }
    }

    public function MasterOverviewWeeklyOfFresh($store_id, $year)
    {
        $weeks = Week::where('year', $year)->get();

        $master_overview_weekly = array();

        foreach ($weeks as $w) {
            $responseValue = 0.00;
            $amtTotal = 0.00;
            $week_number = -1;

            $store_week_id = StoreWeek::storeWeekId($store_id, $w->id);

            $wppRevenues = WeeklyProjectionPercentRevenues::where('store_week_id', $store_week_id)->first();
            $year_reference = $wppRevenues->year_reference;
            $percent = $wppRevenues->percent;

            $week_number = week::find($w->id)->number;

            //$week_reference = Week::findByNumberYear($week_number, $year_reference);

            $week_reference_id = Week::findByNumberYear($week_number, $year_reference)->id;

            $amtTotal = DailyRevenue::totalAmtWeek($store_id, $week_reference_id);

            $responseValue = $amtTotal - ($percent * $amtTotal / 100);


            $day = DailyRevenue::lastDayWeek($store_id, $w->id);

            $actual_weekly_revenue = DailyRevenue::totalAmtWeek($store_id, $w->id);
            $weekly_cog_total = Invoice::total($store_id, $w->id);

            if ($weekly_cog_total == 0) {
                $total = 0;
            } else {
                $total = $weekly_cog_total * 100 / $actual_weekly_revenue;
            }

            $arrayDatos = array(
                'week_id' => $w->id,
                'week_ending_date' => $day->date,
                'week_ending' => Carbon::parse($day->date)->format('M-d'),//$day->month.'-'.$day->month_day,
                'projected_weekly_revenue' => number_format((float)$responseValue, 2, '.', ''),
                'actual_weekly_revenue' => number_format((float)$actual_weekly_revenue, 2, '.', ''),
                'weekly_cog_total' => number_format((float)$weekly_cog_total, 2, '.', ''),
                'target' => number_format((float)WeeklyProjectionPercentCosts::target($store_id, $w->id), 2, '.', ''),
                'actual' => number_format((float)$total, 2, '.', ''),
                'difference' => number_format((float)WeeklyProjectionPercentCosts::target($store_id, $w->id) - $total, 2, '.', ''),
                'down_percent' => $percent,
                'year_reference' => $year_reference,
                'year_reference_revenue' => $amtTotal,
                'week_number' => $week_number
            );

            $master_overview_weekly [] = $arrayDatos;
        }

        return response()->json(['master_overview_weekly' => $master_overview_weekly], 200);
    }

    public function WeeklyProjections($store_id, $year)
    {
        $weeks = Week::where('year', $year)->get();

        $master_overview_weekly = array();

        foreach ($weeks as $w) {
            $day = DailyRevenue::lastDayWeek($store_id, $w->id);

            $responseValue = 0.00;
            $amtTotal = 0.00;
            $week_number = -1;

            $store_week_id = StoreWeek::storeWeekId($store_id, $w->id);

            $wppRevenues = WeeklyProjectionPercentRevenues::where('store_week_id', $store_week_id)->first();
            $year_reference = $wppRevenues->year_reference;
            $percent = $wppRevenues->percent;
            $weekly_projection_percent_revenues_id = $wppRevenues->id;

            $week_number = week::find($w->id)->number;

            $week_reference_id = Week::findByNumberYear($week_number, $year_reference)->id;

            $amtTotal = DailyRevenue::totalAmtWeek($store_id, $week_reference_id);

            $responseValue = $amtTotal - ($percent * $amtTotal / 100);

            $arrayDatos = array(
                'week_ending' => Carbon::parse($day->date)->format('M-d'),//$day->month.'-'.$day->month_day,
                'gross_sales' => number_format((float)$amtTotal, 2, '.', ''),
                'down' => number_format((float)$percent, 2, '.', ''),
                'projection' => number_format((float)$responseValue, 2, '.', ''),
                'target' => $year_reference,
                'weekly_projection_percent_revenues_id' => $weekly_projection_percent_revenues_id
            );

            $master_overview_weekly [] = $arrayDatos;
        }

        return response()->json(['weekly_projections' => $master_overview_weekly], 200);
    }

    public function ProjectionCol($store_id, $year)
    {
        $weeks = Week::where('year', $year)->get();

        $master_overview_weekly = array();

        foreach ($weeks as $w) {
            $responseValue = 0.00;
            $amtTotal = 0.00;
            $week_number = -1;

            $store_week_id = StoreWeek::storeWeekId($store_id, $w->id);

            $wppRevenues = WeeklyProjectionPercentRevenues::where('store_week_id', $store_week_id)->first();
            $year_reference = $wppRevenues->year_reference;
            $percent = $wppRevenues->percent;

            $week_number = week::find($w->id)->number;

            $week_reference_id = Week::findByNumberYear($week_number, $year_reference)->id;
            $amtTotal = DailyRevenue::totalAmtWeek($store_id, $week_reference_id);
            $responseValue = $amtTotal - ($percent * $amtTotal / 100);
            $day = DailyRevenue::lastDayWeek($store_id, $w->id);
            $target_percentage = TargetPercentage::where('store_week_id', $store_week_id)->first();
            $projection_total_hours_allowed = number_format((float)$responseValue * $target_percentage->target_percentage / 16, 2, '.', '');
            //$amtTotal = DailyRevenue::totalAmtWeek($store_id, $week_reference_id);

            $actual_sales = DailyRevenue::totalAmtWeek($store_id,$w->id);

            $schedules = Schedule::findScheduleByStoreWeekAndYear($store_week_id, $year);

            $total_hours = 0.00;

            foreach ($schedules as $sche) {
                $total_hours = $total_hours + Schedule::scheduleDiffHours($sche);//this function actually get minutes, not hours
            }

            $total_hours = Schedule::scheduleMinToHours($total_hours);

            $arrayDatos = array(
                'week_id' => $w->id,
                'week_ending' => Carbon::parse($day->date)->format('M-d'),
                'projected_weekly_revenue' => number_format((float)$responseValue, 2, '.', ''),
                'projection_total_hours_allowed' => $projection_total_hours_allowed,
                'target_percentage' => $target_percentage->target_percentage,
                'actual_sales' => number_format((float)$actual_sales, 2, '.', ''),
                'total_cheduled_hours' => $total_hours,
                'difference' => number_format((float)$projection_total_hours_allowed - $total_hours, '2', '.', '')
            );

            $master_overview_weekly [] = $arrayDatos;
        }

        return response()->json(['projection_col' => $master_overview_weekly], 200);
    }
}
