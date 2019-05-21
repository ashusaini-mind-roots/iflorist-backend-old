<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class RolesController extends Controller
{

    public function index()
    {
        return response()->json(['roles' => Role::all()], 200);
    }

    public function getById($id)
    {
        return response()->json(['role' => Role::find($id)], 200);
    }

    public function create(Request $request)
    {
        $v = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors()
            ], 422);
        }

        $role = new Role;
        $role->name = $request->name;
        $role->description = $request->description;
        $role->save();

        return response()->json(['status' => 'success'], 200);
    }

    public function update(Request $request,$id)
    {
        $v = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors()
            ], 422);
        }

        $role = Role::findOrFail($id);
        $role->name = $request->name;
        $role->description = $request->description;
        $role->update();

        return response()->json(['status' => 'success'], 200);
    }

    public function delete(Request $request,$id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return response()->json(['status' => 'success'], 200);
    }

}
