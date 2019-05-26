<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\StoreWeek;
use App\Models\DailyRevenue;

class DailyRevenuesController extends Controller
{
    public function sevenDaysWeek($store_id, $week_id)
    {
        $seven_days_week = DB::table('daily_revenues')
            ->leftjoin('store_week', 'store_week.id', '=', 'daily_revenues.store_week_id')
            ->leftjoin('dates_dim', 'dates_dim.date', '=', 'daily_revenues.dates_dim_date')
            ->select('daily_revenues.*', 'dates_dim.day_of_week')
            ->where('store_week.store_id', $store_id)
            ->where('store_week.week_id', $week_id)
            ->get();
        //date_format($date, 'Y-m-d H:i:s');
        return response()->json(['seven_days_week' => $seven_days_week], 200);
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
            $daily_revenue->amt = str_replace($search_replace, '', $dr->amt_formatted);
            $daily_revenue->user_id = $user_id;
            $daily_revenue->entered_date = $entered_date;
            $daily_revenue->update();
        }

        return response()->json(['status' => 'success'], 200);
    }
}
