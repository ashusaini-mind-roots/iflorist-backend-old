<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StoreWeek extends Model
{


    public function DailyRevenues()
    {
        return $this->hasMany('App\DailyRevenue');
    }

}
