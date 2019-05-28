<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WeeklyProjectionPercentCosts;
use App\Models\StoreWeek;
use Illuminate\Support\Facades\Validator;

class WeeklyProjectionPercentCostsController extends Controller
{

    public function targetCog($store_id,$week_id)
    {
        if($store_id!=null && $week_id!=null)
        {
            $store_week_id = StoreWeek::storeWeekId($store_id,$week_id);

            $target_cog = WeeklyProjectionPercentCosts::where('store_week_id',$store_week_id)->first()->target_cog;

            return response()->json(['target_cog' => $target_cog], 200);
        }
        else
        {
            return response()->json(['target_cog' => ''], 200);
        }

    }


    public function updateTargetCog(Request $request,$store_id,$week_id)
    {
        $v = Validator::make($request->all(), [
            'target_cog' => 'required'
        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors()
            ], 422);
        }

        $store_week_id = StoreWeek::storeWeekId($store_id,$week_id);

        $weekly_projection = WeeklyProjectionPercentCosts::where('store_week_id',$store_week_id)->first();

        $weekly_projection->target_cog = $request->target_cog;
        $weekly_projection->update();

        return response()->json(['status' => 'success'], 200);

    }

}
