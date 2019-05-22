<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiffProjectionPercentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sql = <<<EOT
INSERT INTO `diff_projection_percent`(`store_week_id`,`year_proyection`,`year_reference`,`percent`,`created_at`,`updated_at`)
SELECT 
    sw.id AS store_week_id,
    w.`year` AS year_proyection,
    w.`year` - 1 AS year_reference,
    0 as percent,now(),now() 
FROM
    store_week sw
        INNER JOIN
    weeks w ON sw.week_id = w.id
    ;
    
UPDATE diff_projection_percent set percent =10 WHERE store_week_id = (SELECT  id FROM store_week WHERE week_id = (SELECT  w.id FROM weeks w WHERE `number` = '02' AND `year` = 2018) AND store_id = 3);
UPDATE diff_projection_percent set percent =50 WHERE store_week_id = (SELECT  id FROM store_week WHERE week_id = (SELECT  w.id FROM weeks w WHERE `number` = '09' AND `year` = 2018) AND store_id = 3);
EOT;
        DB::unprepared($sql);
    }
}
