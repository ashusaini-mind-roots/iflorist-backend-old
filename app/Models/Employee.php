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

    static function findByStore($store_id)
    {
        $employs = DB::table('employees')
            ->join('categories', 'categories.id', '=', 'employees.category_id')
            ->select('employees.*','categories.name as categorie_name')
            ->where('store_id',$store_id)
            ->where('active',1)
            ->get();
        return  $employs;
    }

    static function findByIdCustom($employee_id)
    {
        return 1;
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

//    static function getAllActiveEmployees(){
//        $employees = DB::table('employees')
//            ->leftjoin('stores','employees.store_id','=','stores.id')
//            ->leftjoin('categories','employees.category_id','=','categories.id')
//            ->leftjoin('work_mans_comp','employees.work_man_comp_id','=','work_mans_comp.id')
//            ->where('employees.active',1)
//            ->select('employees.*','work_mans_comp.name as work_man_comp','work_mans_comp.rate as work_man_comp_rate','stores.store_name as store','categories.name as category')
//            ->get();
//
//        return $employees;
//    }
    static function getAllActiveEmployees($store_id){
        $employees = DB::table('employees')
            ->leftjoin('stores','employees.store_id','=','stores.id')
            ->leftjoin('categories','employees.category_id','=','categories.id')
            ->leftjoin('work_mans_comp','employees.work_man_comp_id','=','work_mans_comp.id')
            ->leftjoin('status','employees.status_id','=','status.id')
            ->where('employees.active',1)
            ->where('employees.store_id', '=', $store_id)
            ->select('employees.*','work_mans_comp.name as work_man_comp','work_mans_comp.rate as work_man_comp_rate','stores.store_name as store','categories.name as category',
                'status.name as status_name', 'status.code as status_code','employees.user_id as employees_user_id')
            ->get();

        return $employees;
    }
	
	static function getAllActiveAndInactiveEmployees($store_id){
        $employees = DB::table('employees')
            ->leftjoin('stores','employees.store_id','=','stores.id')
            ->leftjoin('categories','employees.category_id','=','categories.id')
            ->leftjoin('work_mans_comp','employees.work_man_comp_id','=','work_mans_comp.id')
            ->leftjoin('status','employees.status_id','=','status.id')
            ->where('employees.store_id', '=', $store_id)
            ->select('employees.*','work_mans_comp.name as work_man_comp','work_mans_comp.rate as work_man_comp_rate','stores.store_name as store','categories.name as category',
                'status.name as status_name', 'status.code as status_code','employees.user_id as employees_user_id')
            ->get();

        return $employees;
    }
}
