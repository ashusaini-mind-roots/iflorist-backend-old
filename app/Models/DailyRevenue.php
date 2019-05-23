<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DailyRevenue extends Model
{
    public function post()
    {
        return $this->belongsTo('App\Models\StoreWeek');
    }

    static function sevenDaysWeek($store_week_id)
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
}
