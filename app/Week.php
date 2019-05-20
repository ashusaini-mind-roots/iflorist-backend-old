<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Week extends Model
{
    protected $fillable = [
        'number',
        'year'
    ];


    public function stores()
    {
        return $this->belongsToMany('App\Store','store_week', 'week_id', 'store_id');
    }

}
