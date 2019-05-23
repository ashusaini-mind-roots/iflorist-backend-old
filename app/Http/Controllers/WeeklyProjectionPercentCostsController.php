<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WeeklyProjectionPercentCosts;
use App\Models\StoreWeek;

class WeeklyProjectionPercentCostsController extends Controller
{

    public function targetCog($store_id,$week_id)
    {
        $store_week_id = StoreWeek::storeWeekId($store_id,$week_id);

        $target_cog = WeeklyProjectionPercentCosts::where('store_week_id',$store_week_id)->first()->target_cog;

        return response()->json(['target_cog' => $target_cog], 200);
    }


}
