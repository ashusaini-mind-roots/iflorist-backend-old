<?php

namespace App\Http\Controllers;

use App\Services\EmailServices;
use App\Services\MerchantService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Company;
use App\Models\User;
use App\Models\CompanyPlan;
use \Exception;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    public function create(Request $request)
    {

        $v = Validator::make($request->all(), [
            'card_token' => 'required',
            'name' => 'required',
            'email' => 'required',
            //'cc' => 'required',
            // 'cc_expired_date' => 'required',
            'password' => 'required',
            'ba_street' => 'required',
            //'ba_street2' => 'required',
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


        if (is_array($request->plans) == false) {
            return response()->json([
                'status' => 'error',
                'errors' => 'Plans array invalid !'
            ], 422);
        }

//        //Create Customer in Merchant and
//        // store default payment method
//        try {
//            $Merchant = new MerchantService();
//            $CustomerMerchant = $Merchant->createCustomer(
//                $request->email,
//                $request->company_name,
//                $request->card_token,
//                $address = [
//                    'line1' => $request->ba_street,
//                    'line2' => $request->ba_street2,
//                    'city' => $request->ba_city,
//                    'country' => null,
//                    'state' => $request->ba_state,
//                    'postal_code' => $request->ba_zip_code,
//
//                ]
//            );
//        } catch (Exception $e) {
//            return response()->json([
//                'status' => 'error',
//                'errors' => $e->getMessage()
//            ], 422);
//        }

        $emailResponse = null;
        //Create User
        try {
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->role_id = '2';
            //$user->store_id = '2';
            $user->activated_account = 0;
            $user->activation_code_expired_date = date('Y-m-d H:i:s');
            $user->activation_code = Str::random(16);
            $user->password = bcrypt($request->password);
            $user->save();
            $text = config('app.api_url_activation_company') . '/' . $user->user_id . '-' . $user->activation_code;
            $emailResponse = $this->send_activation_mail($user->email, $text);
        } catch (\Exception $e) {
//            $Merchant->deleteCustomer($CustomerMerchant->id);
            return response()->json($e->getMessage(), 500);
        }

        //Create Company in DB
        try {
            $company = new Company();
            $company->name = $request->name;
            $company->ba_street = $request->ba_street;
            $company->ba_street2 = $request->ba_street2;
            $company->ba_city = $request->ba_city;
            $company->ba_state = $request->ba_state;
            $company->ba_zip_code = $request->ba_zip_code;
            $company->card_holder_name = $request->card_holder_name;
            $company->canceled_account = 0;
//            $company->external_customer_id = $CustomerMerchant->id;
            $company->external_customer_id = "customermarchantid";
            $company->user_id = $user->id;
            $company->save();
        } catch (\Exception $e) {
//            $Merchant->deleteCustomer($CustomerMerchant->id);
            return response()->json($e->getMessage(), 500);
        }

        // Assign Plan
        $plans = $request->plans;
        foreach ($plans as $p) {
            try {
                $company_plan = new CompanyPlan();
                $company_plan->company_id = $company->id;
                $company_plan->plan_id = $p;
                $company_plan->save();
            } catch (\Exception $e) {
                return response()->json($e, 500);
            }
        }

        return response()->json(['msg' => 'Your account was created !','email_response' => $emailResponse], 200);
    }

    public function activate_user(Request $request)
    {
        $array_code = explode('-', $request->activation_code);
        $user = User::where('id',$array_code[0])->first();
       // dd($user);
        $emailResponse = null;
        if ($user) {

            if ($user->activation_code == $array_code[1]) {
                $activation_core_expired_date = Carbon::createFromFormat('Y-m-d H:i:s', $user->activation_code_expired_date);
                $datetime = $date = Carbon::now();

                $dif = $activation_core_expired_date->diffInHours($datetime);

                $userObject = new User();
                if ($userObject->if_code_expired($user->id)) {
                    $new_activation_code = Str::random(16);
                    $text = config('app.api_url_activation_company') . '/' . $user->id . '-' . $new_activation_code;
                    $emailResponse = $this->send_activation_mail($user->email, $text);
                    $user->activation_code_expired_date = date('Y-m-d H-i-s');
                    $user->activation_code = $new_activation_code;
                    $user->update();
                    return response()->json(['error' => 'Your activation code has expired, we have sent you a new activation code'], 200);
                }

                $user->activated_acCount = '1';
                $user->update();
                return response()->json(['status' => 'success', 'email_response' => $emailResponse], 200);
            } else {
                return response()->json(['error' => 'Invalid Code', 'email_response' => $emailResponse], 200);
            }
        } else {
            return response()->json(['error' => 'Invalid User', 'email_response' => $emailResponse], 200);
        }
    }


    public function send_activation_mail($email, $text)
    {
        $_email = new EmailServices();
        $html = '<h1>Activation Email</h1><p>' . $text . '</p>';
        try {
            return $_email->sendSimpleEmail($email, $html, 'Activation Email ');
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'errors' => $e->getMessage()
            ], 500);
        }
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
        if ($request->card_number == '1234567891234567')
            return response()->json(['error' => true, 'msg' => 'Valid Card Number !'], 200);
        else
            return response()->json(['error' => false, 'msg' => 'Invalid Card Number !'], 200);

    }

    public function canceled_acount(Request $request)
    {
        try {
            $acount_id = $request->acount_id;
            $company = Company::findOrFail($acount_id);
            $company->canceled_acount = 1;
            $company->update();
            return response()->json(['msg' => 'The account was canceled !'], 200);
        } catch (\Exception $e) {
            return response()->json($e, 500);
        }
    }

    public function testEmail()
    {
        try {
            $Email = new EmailServices();
            return $Email->sendSimpleEmail('emigort@gmail.com', '<h1>test</h1>', 'test');

        } catch (Exception $e) {
            return response()->json([$e->getMessage(), $e->getFile(), $e->getCode(), $e->getLine()], 500);
        }
    }

    public function getStoresByCompany()
    {
        try {
            //return response()->json(['stores' => auth()->user()->id], 200);
            $company = new Company();
            return response()->json(['stores' => $company->getStoresByCompany(auth()->user()->id)], 200);
        } catch (\Exception $e) {
            return response()->json($e, 500);
        }
    }
}
