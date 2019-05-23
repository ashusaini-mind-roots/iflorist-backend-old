<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class StoreWeek extends Model
{


    public function DailyRevenues()
    {
        return $this->hasMany('App\Models\DailyRevenue');
    }

    static function storeWeekId($store_id,$week_id)
    {
        return $store_week = DB::table('store_week')
            ->where('store_id',$store_id)
            ->where('week_id',$week_id)
            ->first()->id;
    }

}
