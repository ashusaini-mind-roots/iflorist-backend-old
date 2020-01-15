<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AppUser;
use Illuminate\Support\Facades\DB;

class AppUserController extends Controller
{
    public function all($store_id)
	{
		$appUsers = DB::table('stores')
            ->leftjoin('app_user', 'app_user.store_id', '=', 'stores.id')
            ->leftjoin('users', 'users.id', '=', 'app_user.user_id')
            ->select('users.*')
            ->where('users.id',auth()->user()->id)
			->where('stores.id',$store_id)
            ->get();
		//$appUsers = AppUser::where('store_id',$store_id)->where('user_id',auth()->user()->id)->get();
		return response()->json(['appUsers' => $appUsers], 200);
	}
}
