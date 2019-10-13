<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Company extends Model
{
    protected $table = 'company';


    public function getStoresByCompany($user_id)
    {
        $user = DB::table('company')
            ->Join('stores','stores.company_id','=','company.id')
            ->where('company.user_id', $user_id)
            ->select('stores.*')
            ->get();

        return  $user;
    }



}
