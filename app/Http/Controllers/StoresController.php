<?php

namespace App\Http\Controllers;

use App\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StoresController extends Controller
{
    public function index()
    {
        return response()->json(['stores' => Store::all()], 200);
    }

    public function getById($id)
    {
        return response()->json(['store' => Store::find($id)], 200);
    }

    public function create(Request $request)
    {
        $v = Validator::make($request->all(), [
            'store_name' => 'required',
            'contact_email' => 'required|email'
        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors()
            ], 422);
        }

        $Store = new Store;
        $Store->store_name = $request->store_name;
        $Store->contact_email = $request->contact_email;
        $Store->contact_phone = $request->contact_phone;
        $Store->zip_code = $request->zip_code;
        $Store->address = $request->address;
        $Store->save();

        return response()->json(['status' => 'success'], 200);
    }

    public function update(Request $request,$id)
    {
        $v = Validator::make($request->all(), [
            'store_name' => 'required',
            'contact_email' => 'required|email'
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
        $Store->update();

        return response()->json(['status' => 'success'], 200);
    }

    public function delete(Request $request,$id)
    {
        $Store = Store::findOrFail($id);
        $Store->delete();

        return response()->json(['status' => 'success'], 200);
    }
}
