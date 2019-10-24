<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class WeeklyProjectionPercentCosts extends Model
{
    protected $table = 'weekly_projection_percent_costs';

    static function target($cost_of)
    {
//        $target = DB::table('weekly_projection_percent_costs')
//            ->get();
        if($cost_of == 'goods')
            return parent::all()->first()->target_cog;
        else  if($cost_of == 'fresh')
            return parent::all()->first()->target_cof;
    }

}
