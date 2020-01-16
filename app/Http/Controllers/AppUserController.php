<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AppUser;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AppUserController extends Controller
{
    public function all($store_id)
	{
		$appUsers = DB::table('app_user')
            ->leftjoin('stores', 'stores.id', '=', 'app_user.store_id')
            ->leftjoin('users', 'users.id', '=', 'app_user.user_id')
            ->select('users.*','app_user.id as app_user_id')
            ->where('stores.id',$store_id)
            ->get();
		//$appUsers = AppUser::where('store_id',$store_id)->where('user_id',auth()->user()->id)->get();
		return response()->json(['appUsers' => $appUsers], 200);
	}
	
	public function create(Request $request)
    {
        $v = Validator::make($request->all(), [
            'store_id' => 'required',
            'name' => 'required',
            'active' => 'required',
            'email' => 'required',
        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors()
            ], 422);
        }

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
		$user->password = Hash::make('123456789');
		$user->activated_account = $request->active;
		$user->save();
		
		$userRole = new UserRole();
		$userRole->user_id = $user->id;
		$userRole->role_id = 3;
		$userRole->save();

        $appUser = new AppUser();
		$appUser->store_id = $request->store_id;
        $appUser->user_id = $user->id;
        $appUser->activate = $request->active;
		$appUser->save();
        
		return response()->json(['status' => 'success'], 200);
    }
	
	public function update(Request $request,$id)
    {
        $v = Validator::make($request->all(), [
            'store_id' => 'required',
            'name' => 'required',
            'active' => 'required',
            'email' => 'required',
        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors()
            ], 422);
        }
		
		$appUser = AppUser::findOrFail($id);
		$appUser->store_id = $request->store_id;
        $appUser->activate = $request->active;
		$appUser->save();
		
		$user = User::findOrFail($appUser->user_id);
		$user->name = $request->name;
		$user->email = $request->email;
		$user->password = Hash::make('123456789');
		$user->activated_account = $request->active;
		$user->update();
		
		return response()->json(['status' => 'success'], 200);
    }
	
	public function getById($id)
    {
        $appUser = AppUser::find($id);
        $data = array();
        $data['appUser'] = $appUser;
        
        $user = User::find($appUser->user_id);
        $data['user'] = $user;
		
		return response()->json(['appUser' => $data], 200);
    }
	
}
