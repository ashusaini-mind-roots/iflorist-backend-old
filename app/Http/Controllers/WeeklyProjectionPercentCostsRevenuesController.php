<?php

namespace App\Http\Controllers;

use App\Models\ProjectionPercentage;
use App\Models\ProjectionPercentageDefault;
use Illuminate\Http\Request;
use App\Models\WeeklyProjectionPercentRevenues;
use App\Models\StoreWeek;
use App\Models\Week;
use App\Models\DailyRevenue;
use League\Flysystem\Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class WeeklyProjectionPercentCostsRevenuesController extends Controller
{
    /**
     * @param $store_id
     * @param $year
     * @param $quarter
     *
     * Projected Sales
     */
    public function projWeeklyRevenueByQuarter($store_id, $year, $quarter){

        $allProjectedSales = [0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, 0.00];

        $left = 1;
        $rigth = 52;
        if($quarter != null){
            $left = ($quarter - 1) * 13 + 1;
            $rigth = $quarter * 13;
        }

        $weeks = Week::where('year', $year)
            ->where('number','>=', $left)
            ->where('number','<=', $rigth)
            ->orderBy('number')
            ->get();
        $weeks = $weeks->toArray();
       // $weeks = array_slice($weeks,($quarter - 1) * 13,13);

        $responseValue = 0.00;
//        for ($i = 0 ;$i < count($weeks) ; $i++){
        foreach ($weeks as $week) {
            $value = $this->getProjWeeklyRevenue($store_id,$week);
            $responseValue += $value;
            $allProjectedSales[($week['number'] - (13 * ($quarter - 1)))-1] = $value;

        }
        return response()->json(['proj_weekly_rev_quarter' => $responseValue, 'all_projected_sales' => $allProjectedSales], 200);
    }

    public function projWeeklyRevenue($store_id,$week_id)
    {
        $responseValue = 0.00;
        $week = week::find($week_id)->toArray();

        try{
            $responseValue = $this->getProjWeeklyRevenue($store_id,$week);
        }
        catch (Exception $e) {
            return response()->json(['proj_weekly_rev' => $responseValue,'error'=>$e], 500);
        }
        return response()->json(['proj_weekly_rev' => $responseValue/*,'amt_total'=>$amtTotal,'week_number'=>$week_number*/], 200);
    }

    private function getProjWeeklyRevenue($store_id,$week_)
    {
        $responseValue = 0.00;
        $amtTotal = 0.00;
        $week = $week_;
        $week_number = $week['number'];
        $week_id = $week['id'];
        $percent = 0;

        $wppRevenues = WeeklyProjectionPercentRevenues::where('store_id', $store_id)
            ->where('year_proyection', $week['year'])
            ->where('week_number', $week['number'])
            ->first();

        $lookInDailyRevenues = false;

        $store_week_id = StoreWeek::storeWeekId($store_id,$week_id);
        if($store_week_id != null){
            $projectionPercentage = ProjectionPercentage::where('store_week_id',$store_week_id)->first();
            if($projectionPercentage)
                $percent = $projectionPercentage->projection_percentage;//15
            else {
                $percent = ProjectionPercentageDefault::where('store_id',$store_id)->first()->projection_percentage_default;
            }
        }

        if($wppRevenues && $wppRevenues->year_reference){
            $year_reference = $wppRevenues->year_reference;//2018
            $percent = $wppRevenues->percent;//5

            $wppRevenues_reference = WeeklyProjectionPercentRevenues::getByStoreIdYearWeekNumber($store_id,$year_reference,/*$week_reference->number*/$week_number)->first();
            if($wppRevenues_reference)//getting amt_total from projections table
            {
                $amtTotal = ($wppRevenues_reference) ? $wppRevenues_reference->amt_total : 0.00/*$this->amtTotal($seven_days_week)*/;

//            $seven_days_week = DailyRevenue::sevenDaysWeekByWeekNumberYear($store_id,$week_number,$year_reference)/*sevenDaysWeek($store_id, $week['id'])*/;
//            $amtTotal = DailyRevenue::amtTotal($seven_days_week);

            $responseValue = $amtTotal - ($percent * $amtTotal / 100);
            }else $lookInDailyRevenues = true;
        }
        else {
            $lookInDailyRevenues = true;
        }
        if($lookInDailyRevenues){//if there is no projections look inside dailyRevenues table
            $seven_days_week = DailyRevenue::sevenDaysWeekByWeekNumberYear($store_id, $week_number,$week['year'] - 1);
            if($seven_days_week && count($seven_days_week) > 0)
            {
                $amtTotal = DailyRevenue::amtTotal($seven_days_week);
                $responseValue = $amtTotal  - ($percent * $amtTotal / 100);
            }else{
                $seven_days_week = DailyRevenue::sevenDaysWeekByWeekNumberYear($store_id,$week_number,$week['year']);
                $amtTotal = DailyRevenue::amtTotal($seven_days_week);
                $responseValue = $amtTotal  - ($percent * $amtTotal / 100);
            }

//            $seven_days_week = DailyRevenue::sevenDaysWeek($store_id, $week['id']);
//            $amtTotal = DailyRevenue::amtTotal($seven_days_week);
//            $responseValue = $amtTotal;
        }
        return $responseValue;
     //   return response()->json(['proj_weekly_rev'=>$responseValue,'reve'=>$wppRevenues]);
//        $responseValue = 0.00;
//        $amtTotal = 0.00;
//        $week = $week_;
//        $week_number = -1;
//        $week_id = $week['id'];
//
//        $wppRevenues = WeeklyProjectionPercentRevenues::where('store_id', $store_id)
//            ->where('year_proyection', $week['year'])
//            ->where('week_number', $week['number'])
//            ->first();
//        if($wppRevenues && $wppRevenues->year_reference){
//            $year_reference = $wppRevenues->year_reference;//2018
//            $percent = $wppRevenues->percent;//5
//
//            $week_number = $week['number'];//52
//            $wppRevenues_reference = WeeklyProjectionPercentRevenues::getByStoreIdYearWeekNumber($store_id,$year_reference,/*$week_reference->number*/$week_number)->first();
//            $amtTotal = ($wppRevenues_reference) ? $wppRevenues_reference->amt_total : 0.00/*$this->amtTotal($seven_days_week)*/;
//
//            $responseValue = $amtTotal - ($percent * $amtTotal / 100);
//        }
//        else {
//            $seven_days_week = DailyRevenue::sevenDaysWeek($store_id, $week['id']);
//            $amtTotal = DailyRevenue::amtTotal($seven_days_week);
//            $responseValue = $amtTotal;
//        }
//        return $responseValue;
    }

    public function updateWeeklyProjectionPercentValue(Request $request,$store_id,$week_id)
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

    public function projections($store_id,$year)
    {
        $projections = WeeklyProjectionPercentRevenues::getWeeklyProjectionPercentRevenues($store_id,$year);
        return response()->json(['projections' => $projections], 200);
    }

    public function update(Request $request,$proyection_id)
    {
        $weeklyProjectionPercentRevenues = WeeklyProjectionPercentRevenues::findOrFail($proyection_id);
//        $weeklyProjectionPercentRevenues->amt_total = $request->amt_total;
        $weeklyProjectionPercentRevenues->percent = $request->adjust;

//        $Store->company_id = $request->company_id;
        $weeklyProjectionPercentRevenues->update();

        return response()->json(['status' => 'success'], 200);
    }
}
