<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\UserRole;
use App\Models\Employee;
use App\Models\StoreWeek;
Use App\Models\EmployeeStoreWeek;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\TaxPercentCalculator;
use Illuminate\Support\Facades\Storage;
use App\Models\Week;
use Illuminate\Support\Facades\Hash;



class EmployeesController extends Controller
{
    public function getAll($store_id)
    {
        $employees = Employee::getAllActiveEmployees($store_id);

        for($i = 0 ; $i < count($employees) ; $i++){
            $emailTemp = '';
            $taxes = $this->getEmployeeTaxes($employees[$i]->hourlypayrate,$employees[$i]->work_man_comp_rate);
            $employees[$i]->hourly_gross_pay =  $taxes + $employees[$i]->hourlypayrate ;
            $employees[$i]->overtime_gross_pay = $taxes + ($employees[$i]->hourlypayrate * 1.5) ;
            $userIdTemp = $employees[$i]->employees_user_id;
            if($userIdTemp != null)
            {
                $user = User::find($userIdTemp);
                //$emailTemp = $employees[$i]->employees_user_id;
                if($user->activated_account=='1')
                {
                    $emailTemp = $user->email;
                }
            }

            $employees[$i]->email = $emailTemp;
        }
        return response()->json(['employees' => $employees], 200);
    }
	
	public function getAllActiveAndInactive($store_id)
    {
        $employees = Employee::getAllActiveAndInactiveEmployees($store_id);

        for($i = 0 ; $i < count($employees) ; $i++){
            $emailTemp = '';
            $taxes = $this->getEmployeeTaxes($employees[$i]->hourlypayrate,$employees[$i]->work_man_comp_rate);
            $employees[$i]->hourly_gross_pay =  $taxes + $employees[$i]->hourlypayrate ;
            $employees[$i]->overtime_gross_pay = $taxes + ($employees[$i]->hourlypayrate * 1.5) ;
            $userIdTemp = $employees[$i]->employees_user_id;
            if($userIdTemp != null)
            {
                $user = User::find($userIdTemp);
                //$emailTemp = $employees[$i]->employees_user_id;
                if($user->activated_account=='1')
                {
                    $emailTemp = $user->email;
                }
            }
			if(Employee::employeeIsStoreAdmin($employees[$i]->id,$store_id))
			{
				$employees[$i]->store_admin = true;
			}
			else
			{
				$employees[$i]->store_admin = false;
			}
            $employees[$i]->email = $emailTemp;
        }
        return response()->json(['employees' => $employees], 200);
    }

    public function getEmployeesByStore($store_id)
	{
		return response()->json(['employees' => Employee::where('store_id',$store_id)->get()], 200);
    }
    
    public function delete($id)
	{
        $employee = Employee::findOrFail($id);
        $employee->active = '0';
        $employee->update();
        return response()->json(['status' => 'success'], 200);
	}

    public function getById($id)
    {
        $employee = Employee::find($id);
        $data = array();
        $data['employee'] = $employee;
        if($employee->system_account=='1')
        {
            $user = User::find($employee->user_id);
            $data['user'] = $user;
        }
        else
        {
            $data['user'] = null;
        }

        return response()->json(['employee' => $data], 200);
    }

    public function getImageById($id)
    {
        $employee = Employee::find($id);
		
		//return response()->file(storage_path('app/employee/oka.jpg'));
		//return response()->json(['employee' => $employee], 200);
        
        if($employee->image!='default')
        {
            //$file = Storage::get('employee/'+$employee->image);
            $path = $employee->image;
            $path = str_replace('/',"\\",$path);
            $path = 'app/'.$path;
            return response()->file(storage_path($path));
			//return response()->json(['status' => storage_path($path)], 200);
        }
        else
        {
            return response()->file(storage_path('app/employee/default.svg'));
        }
        //return response()->file(storage_path('app/test.jpg'));
    }
	
	public function changeStoreAdmin(Request $request)
	{
		$employee_id = $request->employee_id;
		$store_id = $request->store_id;
		
		$employeeRole = Employee::findEmployeeRole($employee_id,$store_id);
		if(!$employeeRole)
			return response()->json(['error' => 'Could not set this employee as Store Manager beacuse it should be set as a System User. Go to edit page and change this employee to a System User !'], 200);
		$user_role = UserRole::find($employeeRole->user_role_id);
		$user_role->role_id = 5;
		
		$storeAdmin = Employee::findStoreAdmin($store_id);
		
		if($storeAdmin)
		{
			//return response()->json(['status' => 'akiiiiiiiiiii'], 200);
			$user_role_store_admin = UserRole::find($storeAdmin->user_role_id);
			$user_role_store_admin->role_id = 2;
			$user_role_store_admin->update();
		}
		
		
		$user_role->update();
		
		return response()->json(['status' => 'success'], 200);
	}
	

    public function create(Request $request)
    {
        $fileUrl = 'default';
        
        if($request->has('image') && $request->file('image')!=null)
           $fileUrl = $request->file('image')->store('employee');
        
           $v = Validator::make($request->all(), [
            'store_id' => 'required',
            'category_id' => 'required',
            'status_id' => 'required',
            'work_man_comp_id' => 'required',
            'name' => 'required',
            'phone_number' => 'required',
            'active' => 'required',
            'overtimeelegible' => 'required',
            'hourlypayrate' => 'required',
        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors()
            ], 422);
        }

        if($request->system_account=='1')
        {
            $user = new User();

            if($user->if_email($request->email))
            {
                return response()->json([
                    'status' => 'error',
                    'error' => 'The email already exist !'
                ], 200);
            }
            
            $user->name = $request->name;
            $user->email = $request->email;
            //$user->role_id = 2;
            $user->password = Hash::make('test');
            $user->activated_account = $request->active;

            $user->save();
			
			$userRole = new UserRole();
			$userRole->user_id = $user->id;
			$userRole->role_id = 2;//Rol EMPLOYEE
			$userRole->save();
        }

        $employee = new Employee();

        $employee->store_id = $request->store_id;
        $employee->category_id = $request->category_id;
        $employee->status_id = $request->status_id;
        $employee->work_man_comp_id = $request->work_man_comp_id;
        if($request->system_account=='1')
            $employee->user_id = $user->id;
        $employee->name = $request->name;
        $employee->phone_number = $request->phone_number;
        $employee->overtimeelegible = $request->overtimeelegible;
        $employee->hourlypayrate = $request->hourlypayrate;
        $employee->image = $fileUrl;
        $employee->active = $request->active;
        $employee->year_pay = $request->year_pay;
        $employee->system_account = $request->system_account;
        

        $employee->save();

        $employee_id = $employee->id;

        $lastWeek = Week::lastWeek();

        $store_week = StoreWeek::where('store_id',$request->store_id)->where('week_id',$lastWeek->id)->first();

        //return response()->json(['status' => $store_week], 200);

        $employee_store_week = new EmployeeStoreWeek();
        $employee_store_week->employee_id = $employee_id;
        $employee_store_week->store_week_id = $store_week->id;
        $employee_store_week->activate = $employee->active;
        $employee_store_week->save();


        return response()->json(['status' => 'success'], 200);
    }

    

    public function update(Request $request, $id)
    {
        $fileUrl = $request->file('image')->store('employee');
        
        $v = Validator::make($request->all(), [
        /*'store_id' => 'required',*/
        'category_id' => 'required',
        'status_id' => 'required',
        'work_man_comp_id' => 'required',
        'name' => 'required',
        'phone_number' => 'required',
        'active' => 'required',
        'overtimeelegible' => 'required',
        'hourlypayrate' => 'required',
        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors()
            ], 422);
        }

        $employee = Employee::findOrFail($id);

        /*$store_week = StoreWeek::where('store_id',$employee->store_id)->get();

        if($employee->store_id!=$request->store_id)
        {
            foreach ($store_week as $sw)
            {
                $employee_store_week = EmployeeStoreWeek::where('store_week_id',$sw->id)->where('employee_id',$id)->first();
                $employee_store_week->activate = false;
                $employee_store_week->update();
            }
        }*/

        /*$employee->store_id = $request->store_id;*/
        $employee->category_id = $request->category_id;
        $employee->status_id = $request->status_id;
        $employee->work_man_comp_id = $request->work_man_comp_id;
        if($request->system_account=='1')
        {
            if($employee->user_id==null)
            {
                $user = new User();
                if($user->if_email($request->email))
                {
                    return response()->json([
                        'status' => 'error',
                        'error' => 'The email already exist !'
                    ], 200);
                }
                $user->name = $request->name;
                $user->email = $request->email;
                //$user->role_id = 2;
                $user->password = Hash::make('test');
                $user->activated_account = $request->active;
                $user->save();
                $employee->user_id = $user->id;
				
				$userRole = new UserRole();
				$userRole->user_id = $user->id;
				$userRole->role_id = 2;//Rol EMPLOYEE
				$userRole->save();
            }
            else
            {
                $user = User::findOrFail($employee->user_id);
                $user->activated_account = '1';
				$user->name = $request->name;
				if($user->email!=$request->email)
				{
					if($user->if_email($request->email))
					{
						return response()->json([
							'status' => 'error',
							'error' => 'The email already exist !'
						], 200);
					}
				}
                $user->email = $request->email;
                $user->update();
            }
        }
        else
        {
            if($employee->user_id!=null)
            {
                $user = User::findOrFail($employee->user_id);
                $user->activated_account = '0';
                $user->update();
            }
        }
        $employee->name = $request->name;
        $employee->phone_number = $request->phone_number;
        $employee->overtimeelegible = $request->overtimeelegible;
        $employee->hourlypayrate = $request->hourlypayrate;
        $employee->image = $fileUrl;
        $employee->active = $request->active;
        $employee->year_pay = $request->year_pay;
        

        $employee->update();

        /*$store_week = StoreWeek::where('store_id',$request->store_id)->get();
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
        }*/

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
