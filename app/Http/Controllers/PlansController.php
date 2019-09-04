<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\Module;

class PlansController extends Controller
{
    public function plans()
    {
        $plans = Plan::all();
        $result = array();
        foreach ($plans as $plan)
        {
            $plan_data = array();
            $plan_data['plan'] = $plan;
            $module = new Module();
            $plan_modules = $module->modules($plan->id);
            $plan_data['modules'] = $plan_modules;
            $result[] = $plan_data;
        }
        return response()->json(['plans' => $result], 200);
    }
}
