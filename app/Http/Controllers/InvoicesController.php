<?php

namespace App\Http\Controllers;

use App\Helpers\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\StoreWeek;
use App\Models\Invoice;

class InvoicesController extends Controller
{

    public function all($cost_of, $store_id, $week_id)
    {
        $store_week = DB::table('store_week')
            ->where('store_id', $store_id)
            ->where('week_id', $week_id)
            ->first();

        $invoices = DB::table('invoices')
            ->where('store_week_id', $store_week->id)
            ->where('goods_or_fresh', $cost_of )
            ->get();

        return response()->json(['invoices' => $invoices], 200);
    }

    public function create(Request $request)
    {
        //El validator da error,dice k no lo puede encontrar.
//        $v = Validator::make($request->all(), [
//            'invoice_number' => 'required',
//            'invoice_name' => 'required',
//            'total' => 'required'
//        ]);
//
//        if ($v->fails()) {
//            return response()->json([
//                'status' => 'error',
//                'errors' => $v->errors()
//            ], 422);
//        }

        $store_id = $request->store_id;
        $week_id = $request->week_id;

        $store_week = DB::table('store_week')
            ->where('store_id', $store_id)
            ->where('week_id', $week_id)
            ->first();

        $invoice = new Invoice();
        $invoice->invoice_number = $request->invoice_number;
        $invoice->invoice_name = $request->invoice_name;
        $invoice->goods_or_fresh = $request->cost_of;
        $invoice->total = Utils::money2Float($request->total);
        $invoice->invoice_date = date('Y-m-d');
        $invoice->store_week_id = $store_week->id;

        $invoice->save();

        return response()->json(['status' => 'success'], 200);


    }

    public function delete($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();

        return response()->json(['status' => 'success'], 200);
    }
}
