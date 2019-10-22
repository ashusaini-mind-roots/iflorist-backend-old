<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Week;
use App\Models\Store;
use App\Models\StoreWeek;
use App\Models\DailyRevenue;
use App\Models\DateDim;
use App\Models\Company;
use Illuminate\Support\Facades\DB;

class WeekDailyRevenues extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:weekdailyrevenues';

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
        $week = new Week();
        $result = $week->lastWeek();
        
        if($result)
        {
            $number = $result->number;
            $year = $result->year;
            
            if($number>=52)
            {
                $year = $year + 1;
                $number = '01';
            }
            else
            {
                $number = $number + 1;
                $number = $number < 10 ? '0' . $number : $number;
                $week = new Week();
            }

            $week->number = $number;
            $week->year = $year;

            $week->save();
        }
        else
        {
            $number = '01';
            $year = date('Y');
            $week = new Week();
            $week->number = $number;
            $week->year = $year;

            $week->save();
        }

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
                    $dailyRevenue->user_id = $company->getUserByCopany($store->company_id);
                    $dailyRevenue->amt = 0;
                    $dailyRevenue->entered_date = date('Y-m-d H:i:s');
                    $dailyRevenue->save();
                }
            }

            //return response()->json(['status' => 'success'], 200);
            $this->info('success');
        } catch (\Exception $e) {
//            $Merchant->deleteCustomer($CustomerMerchant->id);
            //return response()->json($e->getMessage(), 500);
            $this->info($e->getMessage());
        }
    }
}
