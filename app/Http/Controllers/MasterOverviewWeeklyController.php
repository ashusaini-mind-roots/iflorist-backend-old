<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Models\Week;
use App\Models\DailyRevenue;
use App\Models\Invoice;
use App\Models\WeeklyProjectionPercentRevenues;
use App\Models\StoreWeek;
use App\Models\WeeklyProjectionPercentCosts;
use Illuminate\Support\Carbon;
use App\Models\TargetPercentage;
use League\Flysystem\Exception;
use App\Models\Schedule;
use App\Models\EmployeeStoreWeek;
use App\Models\TaxPercentCalculator;

class MasterOverviewWeeklyController extends Controller
{
    public function getDataStoreWeekYear($store_id, $week_nbr, $year_reference_selected)
    {
        try {
            $week_id = Week::findByNumberYear($week_nbr, $year_reference_selected)->id;
            $total = DailyRevenue::totalAmtWeek($store_id, $week_id);
            return response()->json(['total'=>$total]);
        } catch (\Exception $e) {
            return response()->json($e, 500);
        }
    }

    public function MasterOverviewWeeklyOf($cost_of,$store_id, $year)
    {
        $weeks = Week::where('year', $year)->get();

        $master_overview_weekly = array();

        foreach ($weeks as $w) {
            $responseValue = 0.00;
            $amtTotal = 0.00;
            $week_number = -1;

           // $store_week_id = StoreWeek::storeWeekId($store_id, $w->id);

            $wppRevenues = WeeklyProjectionPercentRevenues::where('store_id', $store_id)
                ->where('year_proyection', $year)
                ->where('week_number', $w->number)
                ->first();

            $year_reference = $wppRevenues->year_reference;
            $percent = $wppRevenues->percent;

            $week_number = week::find($w->id)->number;

            //$week_reference = Week::findByNumberYear($week_number, $year_reference);

            $week_reference_id = Week::findByNumberYear($week_number, $year_reference)->id;

            $amtTotal = DailyRevenue::totalAmtWeek($store_id, $week_reference_id);

            $responseValue = $amtTotal - ($percent * $amtTotal / 100);


            $day = DailyRevenue::lastDayWeek($store_id, $w->id);

            $actual_weekly_revenue = DailyRevenue::totalAmtWeek($store_id, $w->id);
            $weekly_cog_total = Invoice::total($store_id, $w->id);

            if ($weekly_cog_total == 0) {
                $total = 0;
            } else {
                $total = $weekly_cog_total * 100 / $actual_weekly_revenue;
            }

            $target = WeeklyProjectionPercentCosts::target($cost_of);

            $arrayDatos = array(
                'week_id' => $w->id,
                'week_ending_date' => $day->date,
                'week_ending' => Carbon::parse($day->date)->format('M-d'),//$day->month.'-'.$day->month_day,
                'projected_weekly_revenue' => number_format((float)$responseValue, 2, '.', ''),
                'actual_weekly_revenue' => number_format((float)$actual_weekly_revenue, 2, '.', ''),
                'weekly_cog_total' => number_format((float)$weekly_cog_total, 2, '.', ''),
                'target' => number_format((float)$target, 2, '.', ''),
                'actual' => number_format((float)$total, 2, '.', ''),
                'difference' => number_format((float)$target - $total, 2, '.', ''),
                'down_percent' => $percent,
                'year_reference' => $year_reference,
                'year_reference_revenue' => $amtTotal,
                'week_number' => $week_number
            );

            $master_overview_weekly [] = $arrayDatos;
        }

        return response()->json(['master_overview_weekly' => $master_overview_weekly], 200);
    }

    public function WeeklyProjections($store_id, $year)
    {
        $weeks = Week::where('year', $year)->get();

        $master_overview_weekly = array();

        foreach ($weeks as $w) {
            $day = DailyRevenue::lastDayWeek($store_id, $w->id);

            $responseValue = 0.00;
            $amtTotal = 0.00;
            $week_number = -1;

            $store_week_id = StoreWeek::storeWeekId($store_id, $w->id);

            $wppRevenues = WeeklyProjectionPercentRevenues::where('store_week_id', $store_week_id)->first();
            $year_reference = $wppRevenues->year_reference;
            $percent = $wppRevenues->percent;
            $weekly_projection_percent_revenues_id = $wppRevenues->id;

            $week_number = week::find($w->id)->number;

            $week_reference_id = Week::findByNumberYear($week_number, $year_reference)->id;

            $amtTotal = DailyRevenue::totalAmtWeek($store_id, $week_reference_id);

            $responseValue = $amtTotal - ($percent * $amtTotal / 100);

            $arrayDatos = array(
                'week_ending' => Carbon::parse($day->date)->format('M-d'),//$day->month.'-'.$day->month_day,
                'gross_sales' => number_format((float)$amtTotal, 2, '.', ''),
                'down' => number_format((float)$percent, 2, '.', ''),
                'projection' => number_format((float)$responseValue, 2, '.', ''),
                'target' => $year_reference,
                'weekly_projection_percent_revenues_id' => $weekly_projection_percent_revenues_id
            );

            $master_overview_weekly [] = $arrayDatos;
        }

        return response()->json(['weekly_projections' => $master_overview_weekly], 200);
    }

    public function ProjectionCol($store_id, $year)
    {
        $weeks = Week::where('year', $year)->get();
        $master_overview_weekly = array();
        $employees = Employee::getEmployeesByStoreId($store_id,1);//omit employees from Driver Category because drivers doesn't take part on money

        foreach ($weeks as $w) {
            $responseValue = 0.00;
            $amtTotal = 0.00;
            $week_number = -1;
            $scheduled_payroll = 0.00;

            $store_week_id = StoreWeek::storeWeekId($store_id, $w->id);

            $wppRevenues = WeeklyProjectionPercentRevenues::where('store_week_id', $store_week_id)->first();
            $year_reference = $wppRevenues->year_reference;
            $percent = $wppRevenues->percent;

            $week_number = week::find($w->id)->number;

            $week_reference_id = Week::findByNumberYear($week_number, $year_reference)->id;
            $amtTotal = DailyRevenue::totalAmtWeek($store_id, $week_reference_id);
            $responseValue = $amtTotal - ($percent * $amtTotal / 100);
            $day = DailyRevenue::lastDayWeek($store_id, $w->id);
            $target_percentage = TargetPercentage::where('store_week_id', $store_week_id)->first();
            $projection_total_hours_allowed = number_format((float)($responseValue * $target_percentage->target_percentage / 100), 2, '.', '');
            //$amtTotal = DailyRevenue::totalAmtWeek($store_id, $week_reference_id);

            $actual_sales = DailyRevenue::totalAmtWeek($store_id,$w->id);
            $employees_with_schedules = [];

            foreach ($employees as $employee) {
                $employee_schedules = Schedule::findByEmployeeAndStoreWeekIds($employee->employee_id,$store_week_id);//those are 7 days of this employee or less days;
                $employees_with_schedules[] = ['employee'=>$employee,'schedules'=>$employee_schedules];
            }
            $employees_general_data = $this->getEmployeeGeneralData($employees_with_schedules);


            $scheduled_payroll = 0;
            foreach ($employees_general_data as $emp_data) {
                $hours = ($emp_data['total_minutes'] )/60;
//                $mins = $emp_data['total_minutes'] % 60;
                if($hours <= 40){
                    $scheduled_payroll += $emp_data['hourly_cost'] * ($hours);
                }else{
                    $scheduled_payroll += $emp_data['hourly_cost'] * 40 + ($emp_data['hourly_cost'] * 1.5 * ($hours - 40));
                }
            }

            $actual_sales_return = number_format((float)$actual_sales, 2, '.', '');
            $projeted_weekly_revenue = number_format((float)$responseValue, 2, '.', '');
            $arrayDatos = array(
                'week_id' => $w->id,
                'week_ending' => Carbon::parse($day->date)->format('M-d'),
                'projected_weekly_revenue' => $projeted_weekly_revenue,
                'projection_total_hours_allowed' => $projection_total_hours_allowed,
                'target_percentage' => $target_percentage->target_percentage,
                'actual_sales' => $actual_sales_return,
                'scheduled_payroll' => $scheduled_payroll,
                'scheduled_payroll_percent' => number_format((float)($actual_sales_return > 0 ? ($scheduled_payroll * 100) / $actual_sales_return : 0), 2, '.', '')  ,
            'actual_payroll_percent' => number_format((float)($scheduled_payroll / ($projeted_weekly_revenue > 0 ? $projeted_weekly_revenue : 1)), 2, '.', ''),
            'employees'=>$employees,
                'employees_general_data'=>$employees_general_data,
                'store_week_id'=>$store_week_id,
                'store_id'=>$store_id
            );

            $master_overview_weekly [] = $arrayDatos;
        }

        return response()->json(['projection_col' => $master_overview_weekly], 200);
    }

    public function getEmployeeGeneralData($employees_with_schedules)
    {
        $tax_perccent_calculator = TaxPercentCalculator::first();
        $total_minutess_separated = [];
        for($i = 0 ; $i < count($employees_with_schedules) ; $i++){
            $total_minutess_separated = [];
            $total_minutess = 0;
            for($j = 0 ; $j < count($employees_with_schedules[$i]['schedules']) ; $j++) {
                $total_minutess += Schedule::scheduleDiffHours($employees_with_schedules[$i]['schedules'][$j]);//this function actually get minutes, not hours
                //$total_minutess_separated[] = [$total_minutess, $employees_with_schedules[$i]['schedules'][$j]];
            }
            $emp = $employees_with_schedules[$i]['employee'];

            $employees_with_schedules[$i]['sui'] = round($emp->employee_hourlypayrate * $tax_perccent_calculator->sui/100,2);
            $employees_with_schedules[$i]['futa'] = round($emp->employee_hourlypayrate * $tax_perccent_calculator->futa/100,2);
            $employees_with_schedules[$i]['social_security'] = round($emp->employee_hourlypayrate * $tax_perccent_calculator->social_security/100,2);
            $employees_with_schedules[$i]['medicare'] = round($emp->employee_hourlypayrate * $tax_perccent_calculator->medicare/100,2);
            $employees_with_schedules[$i]['work_mans_comp_amount'] = round($emp->employee_hourlypayrate * $emp->workmans_rate/100,2);
            $total_taxes = round(
                $employees_with_schedules[$i]['sui'] +
                $employees_with_schedules[$i]['futa'] +
                $employees_with_schedules[$i]['social_security'] +
                $employees_with_schedules[$i]['medicare'] +
                $employees_with_schedules[$i]['work_mans_comp_amount']
                ,2);
            $employees_with_schedules[$i]['total_taxes'] = $total_taxes;
            $employees_with_schedules[$i]['total_minutes'] = $total_minutess;
            $employees_with_schedules[$i]['total_minutes_separated']= $total_minutess_separated;
            $employees_with_schedules[$i]['hourly_cost'] = $emp->employee_hourlypayrate + $employees_with_schedules[$i]['total_taxes'] ;
        }
        return $employees_with_schedules;
    }

    public function get_scheduled_payroll_col($store_id,$week_id)
    {
        $employees = Employee::getEmployeesByStoreId($store_id,1);//omit employees from Driver Category because drivers doesn't take part on money

        $employees_with_schedules = [];
        $store_week_id = StoreWeek::storeWeekId($store_id, $week_id);

        foreach ($employees as $employee) {
            $employee_schedules = Schedule::findByEmployeeAndStoreWeekIds($employee->employee_id,$store_week_id);//those are 7 days of this employee or less days;
            $employees_with_schedules[] = ['employee'=>$employee,'schedules'=>$employee_schedules];
        }
        $employees_general_data = $this->getEmployeeGeneralData($employees_with_schedules);

        $scheduled_payroll = 0.00;
        foreach ($employees_general_data as $emp_data) {
            $hours = ($emp_data['total_minutes'] )/60;//0.95
            $mins = $emp_data['total_minutes'] % 60;//57
            if($hours <= 40){
                $scheduled_payroll += $emp_data['hourly_cost'] * ($hours);
            }else{
                $scheduled_payroll += $emp_data['hourly_cost'] * 40 + ($emp_data['hourly_cost'] * 1.5 * ($hours - 40));
            }
        }

        return response()->json(['scheduled_payroll' => $scheduled_payroll], 200);
    }


}
