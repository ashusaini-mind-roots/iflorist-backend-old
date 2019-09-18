<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Plan extends Model
{
    protected $table = 'plans';

    public function modulesbyuser($user_id)
    {
        $company = DB::table('company')
        ->where('company.user_id',$user_id)
        ->first();

        $modules = DB::table('modules')
        ->select('modules.*')
        ->leftjoin('plan_module','plan_module.module_id','=','modules.id')
        ->leftjoin('plans','plans.id','=','plan_module.plan_id')
        ->leftjoin('company_plan','company_plan.plan_id','=','plans.id')
        ->where('company_plan.company_id',$company->id)
        ->groupby('modules.id')
        ->get();

        return $modules;
    }


}
