<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StoreWeek;
use App\Models\DailyRevenue;
use App\Models\DiffProjectionPercent;

class DiffProjectionsPercentController extends Controller
{
    public function diffProjectionPercent($store_id,$week_id,$year)
    {
        $store_week_id = StoreWeek::storeWeekId($store_id,$week_id);

        $diff_projection_percent = DiffProjectionPercent::where('store_week_id',$store_week_id)
            ->where('year_proyection',$year)->first();

        $year_reference = $diff_projection_percent->year_reference;

        $percent = $diff_projection_percent->percent;

        return response()->json(['diff_projection_percent' => $store_week_id], 200);

    }
}
