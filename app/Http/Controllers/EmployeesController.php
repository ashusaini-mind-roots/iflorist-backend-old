<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Employee;
use App\Models\StoreWeek;
Use App\Models\EmployeeStoreWeek;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\TaxPercentCalculator;


class EmployeesController extends Controller
{
    public function index()
    {
        $employees = Employee::getAllActiveEmployees();

        for($i = 0 ; $i < count($employees) ; $i++){
            $taxes = $this->getEmployeeTaxes($employees[$i]->hourlypayrate,$employees[$i]->work_man_comp_rate);
            $employees[$i]->hourly_gross_pay =  $taxes + $employees[$i]->hourlypayrate ;
            $employees[$i]->overtime_gross_pay = $taxes + ($employees[$i]->hourlypayrate * 1.5) ;
        }
        return response()->json(['employees' => $employees], 200);
    }

    public function getById($id)
    {
        return response()->json(['employee' => Employee::find($id)], 200);
    }

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
        $employee->active = /*$request->active*/true;

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

    public function update(Request $request, $id)
    {
        $v = Validator::make($request->all(), [
            'store_id' => 'required',
            'category_id' => 'required',
            'work_man_comp_id' => 'required',
            'name' => 'required',
            'overtimeelegible' => 'required',
            'hourlypayrate' => 'required',
            'active' => 'required',
        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors()
            ], 422);
        }

        $employee = Employee::findOrFail($id);

        $store_week = StoreWeek::where('store_id',$employee->store_id)->get();

        if($employee->store_id!=$request->store_id)
        {
            foreach ($store_week as $sw)
            {
                $employee_store_week = EmployeeStoreWeek::where('store_week_id',$sw->id)->where('employee_id',$id)->first();
                $employee_store_week->activate = false;
                $employee_store_week->update();
            }
        }

        $employee->store_id = $request->store_id;
        $employee->category_id = $request->category_id;
        $employee->work_man_comp_id = $request->work_man_comp_id;
        $employee->name = $request->name;
        $employee->overtimeelegible = $request->overtimeelegible;
        $employee->hourlypayrate = $request->hourlypayrate;
        $employee->active = $request->active;

        $employee->update();

        $store_week = StoreWeek::where('store_id',$request->store_id)->get();
        foreach ($store_week as $sw)
        {
            $employee_store_week = EmployeeStoreWeek::where('store_week_id',$sw->id)->where('employee_id',$id)->first();
            if($employee_store_week)
            {
                $employee_store_week->activate = true;
            }
            else
            {
                $employee_store_week = new EmployeeStoreWeek();
                $employee_store_week->employee_id = $id;
                $employee_store_week->store_week_id = $sw->id;
                $employee_store_week->save();
            }
        }

        return response()->json(['status' => 'success'], 200);
    }

    public function getEmployeeTaxes($employee_hourlypayrate,$workmans_rate){
        $tax_perccent_calculator = TaxPercentCalculator::first();

        $sui = round($employee_hourlypayrate * $tax_perccent_calculator->sui/100,2);
        $futa = round($employee_hourlypayrate * $tax_perccent_calculator->futa/100,2);
        $social_security = round($employee_hourlypayrate * $tax_perccent_calculator->social_security/100,2);
        $medicare = round($employee_hourlypayrate * $tax_perccent_calculator->medicare/100,2);
        $work_mans_comp_amount = round($employee_hourlypayrate * $workmans_rate/100,2);
        $total_taxes = round(
            $sui+
            $futa+
            $social_security+
            $medicare+
            $work_mans_comp_amount
            ,2);
        return $total_taxes;
    }
}
