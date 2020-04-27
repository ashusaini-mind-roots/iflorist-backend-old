<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class WeeklyProjectionPercentCosts extends Model
{
    protected $table = 'weekly_projection_percent_costs';

    static function target($cost_of,$store_id)
    {
        $data = parent::where('store_id',$store_id)->first();
        if($cost_of == 'goods')
        {
            if($data)
                return $data->target_cog;
            else
                return null;
        }
        else  if($cost_of == 'fresh')
        {
            if($data)
                return $data->target_cof;
            else
                return null;
        }

    }

}
