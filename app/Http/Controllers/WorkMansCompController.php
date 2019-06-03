<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkManComp;

class WorkMansCompController extends Controller
{
    public function index()
    {
        return response()->json(['work_mans_comp' => WorkManComp::all()], 200);
    }
}
