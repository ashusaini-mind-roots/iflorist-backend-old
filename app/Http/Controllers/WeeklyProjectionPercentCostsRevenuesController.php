<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WeeklyProjectionPercentRevenues;
use App\Models\StoreWeek;
use App\Models\Week;
use App\Models\DailyRevenue;
use League\Flysystem\Exception;
use Illuminate\Support\Facades\Validator;

class WeeklyProjectionPercentCostsRevenuesController extends Controller
{
    public function projWeeklyRevenue($store_id,$week_id)
    {
        $responseValue = 0.00;
        $amtTotal = 0.00;
        $week_number = -1;
        try{
            $store_week_id = StoreWeek::storeWeekId($store_id,$week_id);

            $wppRevenues = WeeklyProjectionPercentRevenues::where('store_week_id',$store_week_id)->first();
            $year_reference = $wppRevenues->year_reference;
            $percent = $wppRevenues->percent;

            $week_number = week::find($week_id)->number;
            if($week_number != null) {
                $week_reference = Week::findByNumberYear($week_number, $year_reference);
                if($week_reference != null) {
                    $week_reference_id = Week::findByNumberYear($week_number, $year_reference)->id;

                    $seven_days_week = DailyRevenue::sevenDaysWeek($store_id, $week_reference_id);
                    $amtTotal = $this->amtTotal($seven_days_week);

                    $responseValue = $amtTotal - ($percent * $amtTotal / 100);
                }
            }
        }catch (Exception $e) {
            return response()->json(['ProjWeeklyRev' => $responseValue,'error'=>$e], 500);
        }

        return response()->json(['proj_weekly_rev' => $responseValue,'amt_total'=>$amtTotal,'week_number'=>$week_number], 200);
    }

    public function amtTotal($seven_days_week)
    {
        $total = 0;
        foreach ($seven_days_week as $day){
            $total += $day->amt;
        }
        return $total;
    }

    public function updateWeeklyProjection(Request $request,$store_id,$week_id)
    {
        $v = Validator::make($request->all(), [
            'percent' => 'required',
            'year_reference' => 'required',
        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors()
            ], 422);
        }

        $store_week_id = StoreWeek::storeWeekId($store_id,$week_id);

        $weekly_projection = WeeklyProjectionPercentRevenues::where('store_week_id',$store_week_id)->first();

        $weekly_projection->percent = $request->percent;
        $weekly_projection->year_reference = $request->year_reference;
        $weekly_projection->update();

        return response()->json(['status' => 'success'], 200);

    }
}
