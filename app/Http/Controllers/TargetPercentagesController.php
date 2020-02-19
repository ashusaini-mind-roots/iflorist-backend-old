<?php

namespace App\Http\Controllers;

use App\Models\TargetPercentageDefault;
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
	
	public function update_create_target_porcentage(Request $request)
    {
        $v = Validator::make($request->all(), [
            'target_percentage' => 'required',
			'store_id' => 'required',
			'week_id' => 'required'
        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors()
            ], 422);
        }

        $store_week_id = StoreWeek::storeWeekId($request->store_id,$request->week_id);
        $target_percentage = TargetPercentage::where('store_week_id',$store_week_id)->first();
		if($target_percentage)
		{
			$target_percentage->target_percentage = $request->target_percentage;
			$target_percentage->update();
		}
		else
		{
			$target_percentage = new TargetPercentage();
			$target_percentage->target_percentage = $request->target_percentage;
			$target_percentage->store_week_id = $store_week_id;
			$target_percentage->save();
		}
        

        return response()->json(['status' => 'success'], 200);
    }

    public function get_target($store_id,$week_id)
    {
        $store_week_id = StoreWeek::storeWeekId($store_id,$week_id);

        $tperc = TargetPercentage::where('store_week_id', $store_week_id)->first();

        if($tperc)
            return response()->json(['target_percentage' => $tperc->target_percentage], 200);
        else
        {
            $tpercD = TargetPercentageDefault::where('store_id',$store_id)->first();
            if($tpercD)
                return response()->json(['target_percentage' => $tpercD->target_percentage_default], 200);
        }
        return null;
    }


}
