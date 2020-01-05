<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Role;
use App\Models\User;
use App\Models\Week;
use App\Models\StoreWeek;
use App\Models\Company;
use App\Models\TargetPercentageDefault;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Employee;
use App\Models\TaxPercentCalculator;
use App\Models\WeeklyProjectionPercentRevenues;

class StoresController extends Controller
{
    public function index($user_id,$role_name)
    {
        if($role_name=="Admin")
            $stores = response()->json(['stores' => Store::all()], 200);
        else
        {
            $stores = DB::table('users')
                ->leftjoin('stores','users.store_id','=','stores.id')
                ->select('stores.*')
                ->where('users.id',$user_id)
                ->get();
            //return response()->json(['stores' => $stores], 200);
        }
		
		$result = array();
        foreach ($stores as $store)
        {
            $store_data = array();
            $store_data['store'] = $store;
            $result[] = $store_data;
        }
		
		return response()->json(['stores' => $result], 200);
		
    }

    public function storesByUser($user_id)
    {
        $rol = User::find($user_id)->role;
        $role_name = $rol['name'];
        if($role_name=="Admin")
            return response()->json(['stores' => Store::all()], 200);
        else
        {
            $stores = User::find($user_id)->store;
            return response()->json(['stores' => $stores], 200);
        }
    }

    public function storesEmployeesTaxPercentCalculators($user_id)
    {
        $rol = User::find($user_id)->role;
        $role_name = $rol['name'];
        if($role_name=="Admin")
            $stores = Store::all();
        else
        {
            $store = User::find($user_id)->store;

            $stores [] = $store;
        }
        $stores_employees_tax_percent_calculators_array = array();

        $tax_perccent_calculator = TaxPercentCalculator::first();

        //return response()->json(['stores_employees_tax_percent_calculators_array' => $stores], 200);
        foreach ($stores as $str)
        {
            $stores_array = array();

            $employees = DB::table('employees')
                ->leftjoin('categories', 'categories.id', '=', 'employees.category_id')
                ->leftjoin('work_mans_comp', 'work_mans_comp.id', '=', 'employees.work_man_comp_id')
                ->select('employees.name','employees.hourlypayrate','employees.overtimeelegible','work_mans_comp.rate')
                ->where('employees.store_id',$str->id)
                ->where('employees.active',true)
                ->where('categories.omit_col',false)
                ->get();
            $employees_array = array();
            foreach ($employees as $emp)
            {
                $sui = round($emp->hourlypayrate * $tax_perccent_calculator->sui/100,2);
                $futa = round($emp->hourlypayrate * $tax_perccent_calculator->futa/100,2);
                $social_security = round($emp->hourlypayrate * $tax_perccent_calculator->social_security/100,2);
                $medicare = round($emp->hourlypayrate * $tax_perccent_calculator->medicare/100,2);
                $work_mans_comp_amount = round($emp->hourlypayrate * $emp->rate/100,2);
                $ourly_cost = round($emp->hourlypayrate + $sui + $futa + $social_security + $medicare + $work_mans_comp_amount,2);
                if($emp->overtimeelegible==1)
                    $overtimeelegible = 'Y';
                else
                    $overtimeelegible = 'N';
                $data = array(
                    'employee_name' => $emp->name,
                    'hourly_pay_rate' => $emp->hourlypayrate,
                    'sui' => $sui,
                    'futa' => $futa,
                    'social_security' => $social_security,
                    'medicare' => $medicare,
                    'work_mans_comp' => $emp->rate,
                    'work_mans_comp_amount' => $work_mans_comp_amount,
                    'ourly_cost' => $ourly_cost,
                    'overtime_elegible' => $overtimeelegible,
                    'overtime_hourly' => round($ourly_cost * 1.5,2)
                );

                $employees_array [] = $data;
            }
            $stores_array['store_name'] =  $str->store_name;
            $stores_array['employee'] = $employees_array;

            $stores_employees_tax_percent_calculators_array [] = $stores_array;
        }

        return response()->json(['stores_employees_tax_percent_calculators_array' => $stores_employees_tax_percent_calculators_array], 200);
    }

    public function all()
    {
        return response()->json(['stores' => Store::all()], 200);
    }

    public function getById($id)
    {
		$store = DB::table('stores')
                ->leftjoin('target_percentage_default', 'target_percentage_default.store_id', '=', 'stores.id')
                ->select('stores.*','target_percentage_default.target_percentage_default')
                ->where('stores.id',$id)
                ->first();
        return response()->json(['store' => $store], 200);
    }
	
	public function create(Request $request)
    {
        $v = Validator::make($request->all(), [
            'store_name' => 'required',
			'target_percentage' => 'required',
            /*'contact_email' => 'required|email'*/
        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors()
            ], 422);
        }

        $userId = auth()->user()->id;
        $company = Company::where('user_id',$userId)->first();

        $fileUrl = 'default';

        if($request->has('image') && $request->file('image')!=null)
            $fileUrl = $request->file('image')->store('store');

        $Store = new Store;
        $Store->store_name = $request->store_name;
        $Store->image = $fileUrl;
        $Store->contact_email = $request->contact_email;
        $Store->contact_phone = $request->contact_phone;
        $Store->zip_code = $request->zip_code;
        $Store->address = $request->address;
        $Store->company_id = $company->id;
        $Store->save();
		
		$lastWeek = Week::lastWeek();

        $storeWeek = new StoreWeek();
        $storeWeek->store_id = $Store->id;
        $storeWeek->week_id = $lastWeek->id;
        $storeWeek->save();
		
		$targetPercentage = new TargetPercentageDefault();
        $targetPercentage->store_id = $Store->id;
        $targetPercentage->target_percentage_default = $request->target_percentage;
        $targetPercentage->save();

        return response()->json(['status' => 'success'], 200);
    }

    public function update(Request $request,$id)
    {
        $v = Validator::make($request->all(), [
            'store_name' => 'required',
            /*'contact_email' => 'required|email'*/
        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors()
            ], 422);
        }

        $Store = Store::findOrFail($id);
        $Store->store_name = $request->store_name;
        $Store->contact_email = $request->contact_email;
        $Store->contact_phone = $request->contact_phone;
        $Store->zip_code = $request->zip_code;
        $Store->address = $request->address;
		$Store->city = $request->city;
		$Store->state = $request->state;
//        $Store->company_id = $request->company_id;
        $Store->update();
		
		$targetPercentage = TargetPercentageDefault::where('store_id',$id)->first();
        $targetPercentage->target_percentage_default = $request->target_percentage;
        $targetPercentage->update();

        return response()->json(['status' => 'success'], 200);
    }

    public function delete(Request $request,$id)
    {
        $Store = Store::findOrFail($id);
        $Store->delete();

        return response()->json(['status' => 'success'], 200);
    }
	
	public function setWeeklyProjectionPercentRevenues(Request $request)
	{
		$path = $request->file('file')->store('weekly_projection_cvs');
		
		$handle = fopen(storage_path("app/".$path),"r");
		$header = true;
		
		while($csvLine = fgetcsv($handle,1000,","))
		{
			if($csvLine[0] && $csvLine[4])
			{
				$weeklyProjectionPercentRevenues = WeeklyProjectionPercentRevenues::where('year_proyection',$csvLine[0])->where('week_number',$csvLine[4])->where('store_id',$request->store_id)->first();
				if($weeklyProjectionPercentRevenues)
				{
					$weeklyProjectionPercentRevenues = WeeklyProjectionPercentRevenues::findOrFail($weeklyProjectionPercentRevenues->id);
					$weeklyProjectionPercentRevenues->year_reference = $csvLine[1];
					$weeklyProjectionPercentRevenues->amt_total = $csvLine[2];
					$weeklyProjectionPercentRevenues->percent = $csvLine[3];
					$weeklyProjectionPercentRevenues->update();
				}
				else
				{
					$weeklyProjectionPercentRevenues = new WeeklyProjectionPercentRevenues();
					$weeklyProjectionPercentRevenues->year_proyection = $csvLine[0];
					$weeklyProjectionPercentRevenues->year_reference = $csvLine[1];
					$weeklyProjectionPercentRevenues->amt_total = $csvLine[2];
					$weeklyProjectionPercentRevenues->percent = $csvLine[3];
					$weeklyProjectionPercentRevenues->week_number = $csvLine[4];
					$weeklyProjectionPercentRevenues->store_id = $request->store_id;
					$weeklyProjectionPercentRevenues->save();
				}
			}
		}
		return response()->json(['status' => 'success'], 200);
	}
}
