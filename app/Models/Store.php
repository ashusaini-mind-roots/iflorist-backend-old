<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Store extends Model
{
    protected $fillable = [
        'store_name',
        'contact_phone',
        'zip_code',
        'contact_email',
        'address',
        'city',
        'state'
    ];

    public function weeks()
    {
        return $this->belongsToMany('App\Models\Week');
    }

        public static function getStoreAppUser($user_id){
        $store = DB::table('stores')
            ->Join('app_user','app_user.store_id','=','stores.id')
            ->where('app_user.user_id', $user_id)
            ->get()->first();
        return $store;
    }

    //public function
}
