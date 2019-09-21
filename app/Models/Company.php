<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Company extends Model
{
    protected $table = 'company';



    public function if_active($user_id)
    {
        $company = DB::table('company')
            ->where('company.user_id',$user_id)
            ->first();

        if(!$company)
            return false;

        if($company->activated_acount=='1')
            return true;
        else
            return false;
    }

    public function if_code_expired($user_id)
    {
        $company = DB::table('company')
            ->where('company.user_id',$user_id)
            ->first();

        if(!$company)
            return false;

        $activation_core_expired_date = Carbon::createFromFormat('Y-m-d H:i:s', $company->activation_code_expired_date);
        $datetime = $date = Carbon::now();

        $dif = $activation_core_expired_date->diffInHours($datetime);

        if($dif>config('app.time_activation_code_expired_date'))
        {
            return true; 
        }

        return false;
    }

    public function if_cancel($user_id)
    {
        $company = DB::table('company')
            ->where('company.user_id',$user_id)
            ->first();

        if(!$company)
            return false;

        if($company->canceled_acount=='1')
            return true;
        else
            return false;
    }
}
