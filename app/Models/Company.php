<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Company extends Model
{
    protected $table = 'company';


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
