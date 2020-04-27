<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Invoice extends Model
{
    protected $table = 'invoices';

    static function total($store_id, $week_id, $cost_of = 'fresh')
    {
        $total = DB::table('invoices')
            ->leftjoin('store_week','store_week.id','=','invoices.store_week_id')
            ->select('invoices.*')
            ->where('store_week.store_id',$store_id)
            ->where('store_week.week_id',$week_id)
            ->where('invoices.goods_or_fresh',$cost_of)
            ->get()->sum('total');
        return  $total;
    }
}
