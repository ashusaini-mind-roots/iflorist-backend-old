<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Week;
use App\Models\Store;
use App\Models\StoreWeek;
use App\Models\DailyRevenue;
use App\Models\DateDim;
use App\Models\Company;
use App\Models\Employee;
Use App\Models\EmployeeStoreWeek;
use Illuminate\Support\Facades\DB;

class GenerateWeekData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:generateweekdata';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $weekSave = false;

        $date = DateDim::where('date',date('Y-m-d'))->first();
        $number = $date->week_starting_monday;
        $year = date('Y');

        if(!Week::where('number',$number)->where('year',$year)->first())
        {
            $week = new Week();
            $week->number = $number;
            $week->year = $year;
            $weekSave = true;
            $week->save();
        }

        /*$week = new Week();
        $result = Week::lastWeek();

        $weekSave = false;
        
        if($result)
        {
            $number = $result->number;
            $year = $result->year;
            
            if($number>=52)
            {
                $year = $year + 1;
                $number = '01';

                $week->number = $number;
                $week->year = $year;
                $week->save();
                $weekSave = true;

            }
            else
            {
                $number = $number + 1;
                $number = $number < 10 ? '0' . $number : $number;
                //$week = new Week();
            }

            $week->number = $number;
            $week->year = $year;
            if(!Week::where('number',$week->number)->where('year',$week->year)->first())
            {
                $week->save();
                $weekSave = true;
            }

        }
        else
        {
            
            
            $date = DateDim::where('date',date('Y-m-d'))->first();
            $number = $date->week_starting_monday;
            $year = date('Y');
            $week = new Week();
            $week->number = $number;
            $week->year = $year;
            $weekSave = true;
            $week->save();
        }*/

        if($weekSave)
        {
            try {
                $stores = Store::all();

                $dateDim = new DateDim();
                $company = new Company();

                //return response()->json(['status' => $dateDim->findBy_($week->year,'Monday',$week->number)], 200);

                $daysText = $dateDim->allDaysText();

                foreach($stores as $store)
                {
                    $storeWeek = new StoreWeek();
                    $storeWeek->store_id = $store->id;
                    $storeWeek->week_id = $week->id;
                    $storeWeek->save();


                    foreach($daysText as $text)
                    {
                        $dailyRevenue = new DailyRevenue();
                        $dailyRevenue->store_week_id = $storeWeek->id;
                        //return response()->json(['status' => $company->getUserByCopany($store->company_id)], 200);
                        $dailyRevenue->dates_dim_date = $dateDim->findBy_($week->year,$text,$week->number)->date;
                        $dailyRevenue->user_id = $company->getUserByCompany($store->company_id);
                        $dailyRevenue->merchandise = 0;
                        $dailyRevenue->wire = 0;
                        $dailyRevenue->delivery = 0;
                        $dailyRevenue->entered_date = date('Y-m-d H:i:s');
                        $dailyRevenue->save();
                    }
                }

                $employees = Employee::all();
                foreach ($employees as $employee)
                {
                    $store_week = StoreWeek::storeWeekId($employee->store_id,$week->id);

                    $employee_store_week = new EmployeeStoreWeek();
                    $employee_store_week->employee_id = $employee->id;
                    $employee_store_week->store_week_id = $store_week->id;
                    $employee_store_week->activate = $employee->active;
                    $employee_store_week->save();
                }


                //return response()->json(['status' => 'success'], 200);
                $this->info('GenerateWeekData success');
            } catch (\Exception $e) {
//            $Merchant->deleteCustomer($CustomerMerchant->id);
                //return response()->json($e->getMessage(), 500);
                $this->info($e->getMessage());
            }
        }
        else
        {
            $this->info('This week already exist');
        }


    }
}
