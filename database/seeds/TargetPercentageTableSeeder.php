<?php

use Illuminate\Database\Seeder;

class TargetPercentageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sql = <<<EOT
insert into target_percentages(store_week_id,target_percentage,created_at,updated_at)
SELECT id,25,now(),now() FROM store_week order by id;
EOT;
        DB::unprepared($sql);
    }
}
