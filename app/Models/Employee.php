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

    /**
     * @param $store_id
     * @param int $omit_cat_col
     * @return \Illuminate\Support\Collection
     * $omit_cat_col 1 if you want only employees from not ommited category
     */
    static function getEmployeesByStoreId($store_id, $omit_cat_col = 0)
    {
        $omit_col = $omit_cat_col;
        $omit_col_ = 1;
        if ($omit_cat_col == 1) {
            $omit_col = 0;
            $omit_col_ = 0;
        }

        $employees = DB::table('employees')
            ->join('categories', 'categories.id', '=', 'employees.category_id')
            ->join('work_mans_comp', 'work_mans_comp.id', '=', 'employees.work_man_comp_id')
            ->join('stores','stores.id','=','employees.store_id')
            ->where('employees.active',1)
            ->where('stores.id','=', $store_id)
            ->where('categories.omit_col',$omit_col)
            ->orwhere('categories.omit_col',$omit_col_)
            //->select('employee.id as employee_id')
            ->select('work_mans_comp.name as workmans_name','work_mans_comp.rate as workmans_rate',
                'employees.id as employee_id','employees.hourlypayrate as employee_hourlypayrate',
                'employees.active as employee_active','employees.overtimeelegible as employee_overtimeelegible',
                'employees.name as employee_name',
                'categories.code as categorie_code','categories.omit_col',
                'stores.store_name', 'categories.omit_col as category_omit_col')
            ->get();

        return $employees;
    }
}
