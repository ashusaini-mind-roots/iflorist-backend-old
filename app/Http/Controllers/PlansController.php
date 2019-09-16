<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\User;
use App\Models\Module;
use Illuminate\Support\Facades\DB;

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

    public function plansbyuser($user_id)
    {
        

        $company = DB::table('companys')
        ->where('companys.user_id',$user_id)
        ->first();

        $plans = DB::table('plans')
        ->leftjoin('company_plan','company_plan.plan_id','=','plans.id')
        ->where('company_plan.company_id',$company->id)
        ->get();

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
