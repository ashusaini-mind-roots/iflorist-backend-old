<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;

class StoreWeekTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*$sql = "
            insert into store_week(store_id,week_id,created_at,updated_at)
            SELECT 
                s.id,w.id,now(),now()
            FROM
                weeks w
                cross join stores s ;
    ";

        DB::unprepared($sql);*/
    }


}
