<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function index()
    {
        dd('hello');
    }

    public function users()
    {
        $users = DB::table('users')
            ->leftjoin('stores','users.store_id','=','stores.id')
            ->leftjoin('roles','users.role_id','=','roles.id')
            ->select('stores.store_name','users.*','roles.name as role_name')
            ->get();
        return response()->json(['users' => $users], 200);
    }

    public function register(Request $request)
    {
        $v = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'role_id' => 'required',
            'store_id' => 'required',
            /*'password' => 'required|min:8|confirmed'*/
            'password' => 'required|min:8'
        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors()
            ], 422);
        }

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        $user->store_id = $request->store_id;
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json(['status' => 'success'], 200);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if ($token = $this->guard()->attemp($credentials)) {
            return response()->json(['status' => 'success'], 200);
        }
        dd('hello');
        return response()->json(['error' => 'login_error'], 401);
    }

    public function logout()
    {
        $this->guard()->logout();
        return respose()->json([
            'status' => 'success',
            'msg' => 'Logged out Successfully'
        ], 200);
    }

    public function refresh()
    {
        if ($token = $this->guard()->refresh()) {
            return response()
                ->json(['status' => 'success'], 200)
                ->header('Authorization', $token);
        }
        return response()->json(['error' => 'refresh_token_error'], 302);
    }

    private function guard()
    {
        return Auth::guard();
    }

    public function delete(Request $request,$id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['status' => 'success'], 200);
    }

    public function getById($id)
    {
        return response()->json(['user' => User::find($id)], 200);
    }

    public function update(Request $request,$id)
    {
        $v = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'role_id' => 'required',
            'store_id' => 'required',
            'password' => 'required|min:8'
        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors()
            ], 422);
        }

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        $user->store_id = $request->store_id;
        $user->password = bcrypt($request->password);
        $user->update();

        return response()->json(['status' => 'success'], 200);
    }
}
