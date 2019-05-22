<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DailyRevenue extends Model
{
    public function post()
    {
        return $this->belongsTo('App\Models\StoreWeek');
    }


}
