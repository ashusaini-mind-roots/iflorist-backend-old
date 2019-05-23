<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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

    static public function findByNumberYear($number, $year)
    {
        return $week = DB::table('weeks')
            ->where('number',$number)
            ->where('year',$year)
            ->first();
    }
}
