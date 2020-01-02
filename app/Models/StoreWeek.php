<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class StoreWeek extends Model
{
    protected $table = 'store_week';

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

    static function getAllStoreWeeksByStoreAndYear($store_id, $year, $quarter = null)
    {
        $left = 1;
        $rigth = 52;
        if($quarter != null){
            $left = ($quarter - 1) * 13 + 1;
            $rigth = $quarter * 13;
        }

        return $storeweks = DB::table('store_week')
            ->join('weeks', 'store_week.week_id', '=', 'weeks.id')
            ->where('store_week.store_id', $store_id)
            ->where('weeks.year', $year)
            ->where('weeks.number','>=', $left)
            ->where('weeks.number','<=', $rigth)
            ->orderBy('weeks.number')
            ->get();
    }

    static function getAllStoreWeeksByStoreAndYearQuarters($store_id, $year, $quarter ){
        $store_weeks = StoreWeek::getAllStoreWeeksByStoreAndYear($store_id, $year, $quarter);
        $store_weeks = $store_weeks->toArray();
        return $store_weeks /*= array_slice($store_weeks,($quarter - 1) * 13,13)*/;
    }

    /*static function storeWeekId($store_id,$week_id)
    {
        return $store_week = DB::table('store_week')
            ->where('store_id',$store_id)
            ->where('week_id',$week_id)
            ->first()->id;
    }*/

}
