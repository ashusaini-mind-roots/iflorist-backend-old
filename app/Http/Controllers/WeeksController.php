<?php

namespace App\Http\Controllers;

use function foo\func;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Models\Week;
use Illuminate\Support\Facades\DB;

class WeeksController extends Controller
{

    public function weekByYear($year)
    {
        $weeks = DB::table('weeks')
            ->select('weeks.id', 'weeks.number', 'weeks.year','dates_dim.date', DB::raw('DATE_FORMAT(`dates_dim`.`date`, "%m/%d") as week_end_day'))
            ->join('dates_dim', function ($join) use ($year) {
                $join->on('weeks.number', '=', 'dates_dim.week_starting_monday')
                    ->where('dates_dim.week_year', '=', $year);
            })
            ->where([
                ['weeks.year', '=', $year],
                ['dates_dim.day_of_week', '=', 'Sunday'],
                //['dates_dim.week_starting_monday','=',$year]
            ])
            ->orderBy('weeks.number', 'asc')
            ->get();

        return response()->json(['weeks' => $weeks], 200);
    }


}
