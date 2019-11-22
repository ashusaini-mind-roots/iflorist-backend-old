<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Statu;

class StatusController extends Controller
{
    public function index()
    {
        return response()->json(['status' => Statu::all()], 200);
    }
}
