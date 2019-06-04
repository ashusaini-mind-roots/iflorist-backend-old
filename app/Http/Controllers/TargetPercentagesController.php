<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StoreWeek;
use App\Models\TargetPercentage;
use Illuminate\Support\Facades\Validator;

class TargetPercentagesController extends Controller
{
    public function update_target_porcentage(Request $request,$store_id,$week_id)
    {
        $v = Validator::make($request->all(), [
            'target_percentage' => 'required'
        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors()
            ], 422);
        }

        $store_week_id = StoreWeek::storeWeekId($store_id,$week_id);
        $target_percentage = TargetPercentage::where('store_week_id',$store_week_id)->first();
        $target_percentage->target_percentage = $request->target_percentage;
        $target_percentage->update();

        return response()->json(['status' => 'success'], 200);
    }
}
