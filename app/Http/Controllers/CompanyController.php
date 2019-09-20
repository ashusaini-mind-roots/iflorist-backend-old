<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Company;
use App\Models\User;
use App\Models\CompanyPlan;
use \Exception;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CompanyController extends Controller
{
    public function create(Request $request)
    {
        $v = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'cc' => 'required',
            'cc_expired_date' => 'required',
            'password' => 'required',
            'ba_street' => 'required',
            'ba_street2' => 'required',
            'ba_city' => 'required',
            'ba_state' => 'required',
            'ba_zip_code' => 'required',
            'card_holder_name' => 'required',
            'plans' => 'required',
        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors()
            ], 422);
        }

        if(is_array($request->plans)==false)
        {
            return response()->json([
                'status' => 'error',
                'errors' => 'Plans array invalid !'
            ], 422);
        }

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = '2';
        $user->store_id = '2';
        $user->password = bcrypt($request->password);
        try{
            $user->save();
        }
        catch (\Exception $e)
        {
            return response()->json($e, 500);
        }


        $user_id = $user->id;

        $company = new Company();
        $company->name = $request->name;
        $company->card_number = $request->card_number;
        $company->cc = $request->cc;
        $company->cc_expired_date = $request->cc_expired_date;
        $company->ba_street = $request->ba_street;
        $company->ba_street2 = $request->ba_street2;
        $company->ba_city = $request->ba_city;
        $company->ba_state = $request->ba_state;
        $company->ba_zip_code = $request->ba_zip_code;
        $company->card_holder_name = $request->card_holder_name;
        $company->user_id = $user_id;
        $company->canceled_acount = 0;
        $company->activated_acount = 0;
        $company->activation_code_expired_date = date('Y-m-d H:i:s');
        $company->activation_code = Str::random(16);
        
        $company->save();
        try{
            $company->save();

            $texto = config('app.api_url_activation_company').'/'.$company->user_id.'-'.$company->activation_code;
            $this->send_mail($user->email, $texto);
        }
        catch (\Exception $e)
        {
            return response()->json($e, 500);
        }

        $plans = $request->plans;
        foreach ($plans as $p)
        {
            try{
                $company_plan = new CompanyPlan();
                $company_plan->company_id = $company->id;
                $company_plan->plan_id = $p;
                $company_plan->save();
            }
            catch (\Exception $e)
            {
                return response()->json($e, 500);
            }
        }

        return response()->json(['msg' => 'Your acount was created !'], 200);
    }

    public function activate_company(Request $request)
    {
        
        $array_code = explode('-',$request->activation_code);
        
        $company = Company::find($array_code[0]);
        if($company)
        {
            
            if($company->activation_code == $array_code[1])
            {
                $activation_core_expired_date = Carbon::createFromFormat('Y-m-d H:i:s', $company->activation_code_expired_date);
                $datetime = $date = Carbon::now();

                $dif = $activation_core_expired_date->diffInHours($datetime);

                if($dif>config('app.time_activation_code_expired_date'))
                {
                    $new_activation_code = Str::random(16);
                    $user = User::find($company->user_id);
                    $texto = config('app.api_url_activation_company').'/'.$company->user_id.'-'.$new_activation_code;
                    $this->send_mail($user->email, $texto);
                    $company->activation_code_expired_date = date('Y-m-d H-i-s');
                    $company->activation_code = $new_activation_code;
                    $company->update();
                    return response()->json(['error' => 'Your activation code has been expired, we sended you a new activation code'], 200);
                }

                return response()->json(['status' => $dif], 200);

                $company->activated_acount = '1';
                $company->update();
                return response()->json(['status' => 'success'], 200);
            }
            else
            {
                return response()->json(['error' => 'Invalid Code'], 200);
            }
        }
        else
        {
            return response()->json(['error' => 'Invalid User'], 200);
        }
    }


    public function send_mail($email,$text)
    {

    }

    public function valid_card(Request $request)
    {
        $v = Validator::make($request->all(), [
            'card_number' => 'required',
            'ba_zip_code' => 'required',
            'cc' => 'required',
            'card_holder_name' => 'required',
        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors()
            ], 422);
        }

        /*Implementar aquí la lógica de validación.*/
        if($request->card_number=='1234567891234567')
            return response()->json(['error' => true,'msg' => 'Valid Card Number !'], 200);
        else
            return response()->json(['error' => false,'msg' => 'Invalid Card Number !'], 200);

    }

    public function canceled_acount(Request $request)
    {
        try{
            $acount_id = $request->acount_id;
            $company = Company::findOrFail($acount_id);
            $company->canceled_acount = 1;
            $company->update();
            return response()->json(['msg' => 'The acount was canceled !'], 200);
        }
        catch (\Exception $e)
        {
            return response()->json($e, 500);
        }


    }
}
