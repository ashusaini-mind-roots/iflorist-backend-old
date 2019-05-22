<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Week extends Model
{
    protected $fillable = [
        'number',
        'year'
    ];


    public function stores()
    {
        return $this->belongsToMany('App\Models\Store','store_week', 'week_id', 'store_id');
    }

}
