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
        $stores = DB::table('company')
            ->Join('stores','stores.company_id','=','company.id')
            ->where('company.user_id', $user_id)
            ->select('stores.*')
            ->get();

        return  $stores;
    }
	
	public static function hasStore($store_id,$user_id)
    {
        $stores = DB::table('company')
            ->Join('stores','stores.company_id','=','company.id')
            ->where('company.user_id', $user_id)
			->where('stores.id', $store_id)
            ->select('stores.*')
            ->get();

        return  $stores;
    }

    public function getUserByCompany($companyId)
    {
        $userId = DB::table('company')
            ->where('company.id', $companyId)
            ->select('company.user_id')
            ->first()->user_id;

        return  $userId;
    }

    public static function getCompanyAppUser($user_id){
        $company = DB::table('company')
            ->Join('stores','stores.company_id','=','company.id')
            ->leftJoin('app_user','app_user.store_id','=','stores.id')
            ->where('app_user.user_id', $user_id)
            ->get()->first();
        return $company;
    }




}
