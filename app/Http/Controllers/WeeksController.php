<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Models\Week;

class WeeksController extends Controller
{

    public function weekByYear($year)
    {
        $weeks = Week::where('year',$year)
            ->orderBy('number','asc')
            ->get();

        return response()->json(['weeks' => $weeks], 200);
    }


}
