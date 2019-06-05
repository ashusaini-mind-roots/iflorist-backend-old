<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Employee extends Model
{
    protected $table = 'employees';

    static function findByCategoryStore($category_id,$store_id)
    {
        $employs = DB::table('employees')
            ->where('category_id',$category_id)
            ->where('store_id',$store_id)
            ->where('active',1)

            ->get();
        return  $employs;
    }
}
