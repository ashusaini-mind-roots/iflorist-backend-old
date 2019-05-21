<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Models\Week;
use Illuminate\Support\Facades\DB;

class WeeksController extends Controller
{

    public function weekByYear($year)
    {
        $weeks = DB::table('weeks')
            ->where('year',$year)
            ->orderBy('number','asc')
            ->get();

        return response()->json(['weeks' => $weeks], 200);
    }


}
