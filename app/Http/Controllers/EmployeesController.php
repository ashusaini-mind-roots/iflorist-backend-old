<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Employee;
use App\Models\StoreWeek;
Use App\Models\EmployeeStoreWeek;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class EmployeesController extends Controller
{
    public function create(Request $request)
    {
        $v = Validator::make($request->all(), [
            'store_id' => 'required',
            'category_id' => 'required',
            'work_man_comp_id' => 'required',
            'name' => 'required',
            'overtimeelegible' => 'required',
            'hourlypayrate' => 'required',
        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors()
            ], 422);
        }

        $employee = new Employee();

        $employee->store_id = $request->store_id;
        $employee->category_id = $request->category_id;
        $employee->work_man_comp_id = $request->work_man_comp_id;
        $employee->name = $request->name;
        $employee->overtimeelegible = $request->overtimeelegible;
        $employee->hourlypayrate = $request->hourlypayrate;
        $employee->active = true;

        $employee->save();

        $employee_id = $employee->id;

        $store_week = StoreWeek::where('store_id',$request->store_id)->get();

        //return response()->json(['status' => $store_week], 200);

        foreach ($store_week as $sw)
        {
            $employee_store_week = new EmployeeStoreWeek();
            $employee_store_week->employee_id = $employee_id;
            $employee_store_week->store_week_id = $sw->id;
            $employee_store_week->save();
        }

        return response()->json(['status' => 'success'], 200);


    }
}
