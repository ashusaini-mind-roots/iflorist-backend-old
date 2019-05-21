<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\StoreWeek;
use App\Invoice;

class InvoicesController extends Controller
{

    public function all($store_id,$week_id)
    {
        $store_week = DB::table('store_week')
            ->where('store_id',$store_id)
            ->where('week_id',$week_id)
            ->first();

        $invoices = Invoice::where('store_week_id',$store_week->id);

        return response()->json(['invoices' => $invoices], 200);
    }

    public function create(Request $request)
    {
        $v = Validator::make($request->all(), [
            'invoice_number' => 'required',
            'invoice_name' => 'required'
        ]);

        if ($v->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors()
            ], 422);
        }

        $store_id = $request->store_id;
        $week_id = $request->week_id;

        $store_week = DB::table('store_week')
            ->where('store_id',$store_id)
            ->where('week_id',$week_id)
            ->first();

        $invoice = new Invoice();
        $invoice->invoice_number = $request->invoice_number;
        $invoice->invoice_name = $request->invoice_name;
        $invoice->invoice_date = date('Y-m-d');
        $invoice->store_week_id = $store_week->id;

        $invoice->save();

        return response()->json(['status' => 'success'], 200);


    }
}