<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\StoreWeek;
use App\DailyRevenue;

class DailyRevenuesController extends Controller
{
    public function sevenDaysWeek($store_id,$week_id)
    {
        $seven_days_week = DB::table('daily_revenues')
            ->leftjoin('store_week','store_week.id','=','daily_revenues.store_week_id')
            ->leftjoin('dates_dim','dates_dim.date','=','daily_revenues.dates_dim_date')
            ->select('daily_revenues.*','dates_dim.day_of_week')
            ->where('store_week.store_id',$store_id)
            ->where('store_week.week_id',$week_id)
            ->get();
        return response()->json(['seven_days_week' => $seven_days_week], 200);
    }

    public function update(Request $request,$id)
    {
        $v = Validator::make($request->all(), [
            'amt' => 'required',
            'user_id' => 'required',
            'entered_date' => 'required'

        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors()
            ], 422);
        }

        $daily_revenue = DailyRevenue::findOrFail($id);
        $daily_revenue->amt = $request->amt;
        $daily_revenue->user_id = $request->user_id;
        $daily_revenue->entered_date = $request->entered_date;
        $daily_revenue->update();
        return response()->json(['status' => 'success'], 200);
    }
}
