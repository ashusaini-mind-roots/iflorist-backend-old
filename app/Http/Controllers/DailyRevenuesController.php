<?php

namespace App\Http\Controllers;

use App\Helpers\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\StoreWeek;
use App\Models\DailyRevenue;

class DailyRevenuesController extends Controller
{
    public function sevenDaysWeek($store_id, $week_id)
    {
//        $seven_days_week = DB::table('daily_revenues')
//            ->leftjoin('store_week', 'store_week.id', '=', 'daily_revenues.store_week_id')
//            ->leftjoin('dates_dim', 'dates_dim.date', '=', 'daily_revenues.dates_dim_date')
//            ->select('daily_revenues.*', 'dates_dim.day_of_week')
//            ->where('store_week.store_id', $store_id)
//            ->where('store_week.week_id', $week_id)
//            ->get();
        //date_format($date, 'Y-m-d H:i:s');
        return response()->json(['seven_days_week' => $this->sevenDaysWeek_aux($store_id, $week_id)], 200);
    }
    public function sevenDaysWeek_aux($store_id, $week_id)
    {
        $seven_days_week = DB::table('daily_revenues')
            ->leftjoin('store_week', 'store_week.id', '=', 'daily_revenues.store_week_id')
            ->leftjoin('dates_dim', 'dates_dim.date', '=', 'daily_revenues.dates_dim_date')
            ->select('daily_revenues.*', 'dates_dim.day_of_week',DB::raw('merchandise + wire + delivery as total'))
            ->where('store_week.store_id', $store_id)
            ->where('store_week.week_id', $week_id)
            ->get();
        //date_format($date, 'Y-m-d H:i:s');
//        return response()->json(['seven_days_week' => $seven_days_week], 200);
        return $seven_days_week;
    }
    public function updateAllAmt(Request $request)
    {
        $daily_revenues [] = json_decode($request->monday);
        $daily_revenues [] = json_decode($request->tuesday);
        $daily_revenues [] = json_decode($request->wednesday);
        $daily_revenues [] = json_decode($request->thursday);
        $daily_revenues [] = json_decode($request->friday);
        $daily_revenues [] = json_decode($request->saturday);
        $daily_revenues [] = json_decode($request->sunday);

        $user_id = $request->user_id;
        $entered_date = date('Y-m-d H:i:s');
        $search_replace = [',', '$'];
        foreach ($daily_revenues as $dr) {
            $daily_revenue = DailyRevenue::findOrFail($dr->id);
            $daily_revenue->amt = Utils::money2Float($dr->amt_formatted);
            $daily_revenue->user_id = $user_id;
            $daily_revenue->entered_date = $entered_date;
            $daily_revenue->update();
        }

        return response()->json(['status' => 'success'], 200);
    }

    public function update(Request $request, $id)
    {
        $dailyRevenue = DailyRevenue::findOrFail($id);
        $dailyRevenue->merchandise = $request->merchandise;
        $dailyRevenue->wire = $request->wire;
        $dailyRevenue->delivery = $request->delivery;

//        $Store->company_id = $request->company_id;
        $dailyRevenue->update();

        return response()->json(['status' => 'success'], 200);
    }

    public function getSales($store_id, $year, $quarter)
    {
        $store_weeks = StoreWeek::getAllStoreWeeksByStoreAndYearQuarters($store_id, $year, $quarter);
//        $store_weeks = StoreWeek::getAllStoreWeeksByStoreAndYear($store_id, $year);
//        $store_weeks = $store_weeks->toArray();
//        $store_weeks = array_slice($store_weeks,($quarter - 1) * 13,13);
        $weeks_return = [];

        for ($i = 0 ; $i < count($store_weeks) ; $i++)
        {
            $week = DB::table('weeks')
            ->where('weeks.number', $store_weeks[$i]->number)
            ->where('weeks.year', $year)
            ->select('weeks.id')
            ->first();

            $store_week = DB::table('store_week')
            ->where('store_week.store_id', $store_id)
            ->where('store_week.week_id', $week->id)
            ->select('store_week.id')
            ->first();

            $dailyRevenues = DB::table('daily_revenues')
            ->Join('dates_dim','dates_dim.date','=','daily_revenues.dates_dim_date')
            ->where('daily_revenues.store_week_id', $store_week->id)
            ->select('dates_dim.*')
            ->get();

            $seven_days = $this->sevenDaysWeek_aux($store_weeks[$i]->store_id, $store_weeks[$i]->week_id);
            if($seven_days)
            {
                $totalMerchandise = 0;
                $totalWire = 0;
                $totalDelivery = 0;
                foreach($seven_days as $d)
                {
                    $totalMerchandise = $totalMerchandise + $d->merchandise;
                    $totalWire = $totalWire + $d->wire;
                    $totalDelivery = $totalDelivery + $d->delivery;
                }
                $weeks_return[] = [
                    'number'=>$store_weeks[$i]->number,
                    'id'=>$store_weeks[$i]->id,
                    'year'=>$store_weeks[$i]->year,
                    'days'=>$seven_days,
                    'week' => $dailyRevenues[0]->month.' '.$dailyRevenues[0]->month_day.' - '.$dailyRevenues[6]->month.' '.$dailyRevenues[6]->month_day,
                    'totalMerchandise' => $totalMerchandise,
                    'totalWire' => $totalWire,
                    'totalDelivery' => $totalDelivery
                    //'store_week' => $store_weeks
                ];
            }
        }
        return response()->json(['weeks' => $weeks_return], 200);
    }
}
