<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class WeeklyProjectionPercentCosts extends Model
{
    protected $table = 'weekly_projection_percent_costs';

    static function target($store_id,$week_id)
    {
        $target_cog = DB::table('weekly_projection_percent_costs')
            ->leftjoin('store_week','store_week.id','=','weekly_projection_percent_costs.store_week_id')
            ->select('weekly_projection_percent_costs.*')
            ->where('store_week.store_id',$store_id)
            ->where('store_week.week_id',$week_id)
            ->first()->target_cog;
        return  $target_cog;
    }

}
