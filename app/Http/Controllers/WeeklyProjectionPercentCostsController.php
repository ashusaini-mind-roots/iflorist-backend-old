<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WeeklyProjectionPercentCosts;
use App\Models\StoreWeek;
use Illuminate\Support\Facades\Validator;

class WeeklyProjectionPercentCostsController extends Controller
{

    public function target($cost_of/*$store_id,$week_id*/)
    {
        try
        {
//            $store_week_id = StoreWeek::storeWeekId($store_id,$week_id);
            $targetCog = '';
            $targetCof = '';

            if($cost_of == 'goods')
                $targetCog = WeeklyProjectionPercentCosts::all()->first()->target_cog;
            else
                $targetCof = WeeklyProjectionPercentCosts::all()->first()->target_cof;

            return response()->json(['target_cog' => $targetCog, 'target_cof' => $targetCof], 200);
        }
        catch (Exception $e)
        {
            return response()->json(['target_cog' => '', 'target_cof' => ''], 200);
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
