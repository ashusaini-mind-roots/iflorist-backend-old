<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WeeklyProjectionPercentCostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sql = <<<EOT
insert into weekly_projection_percent_costs(target_cog,target_cof,created_at,updated_at)
SELECT 5,20,now(),now() FROM store_week order by id;
EOT;
        DB::unprepared($sql);
    }
}
