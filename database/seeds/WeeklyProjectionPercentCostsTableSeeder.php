<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\WeeklyProjectionPercentCosts;

class WeeklyProjectionPercentCostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        WeeklyProjectionPercentCosts::create([
            'target_cog' => 5,
            'target_cof' => 20,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        /*$sql = <<<EOT
insert into weekly_projection_percent_costs(target_cog,target_cof,created_at,updated_at)
SELECT 5,20,now(),now() FROM store_week order by id;
EOT;
        DB::unprepared($sql);*/
    }
}
