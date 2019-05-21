<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;

class DatesDimTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $from = '2016-01-01';
        $to = '2030-01-01';
        $sql = <<<EOT
###### small-numbers table
DROP TABLE IF EXISTS numbers_small;
CREATE TABLE numbers_small (number INT);
INSERT INTO numbers_small VALUES (0),(1),(2),(3),(4),(5),(6),(7),(8),(9);

###### main numbers table
DROP TABLE IF EXISTS numbers;
CREATE TABLE numbers (number BIGINT);
INSERT INTO numbers
SELECT thousands.number * 1000 + hundreds.number * 100 + tens.number * 10 + ones.number
  FROM numbers_small thousands, numbers_small hundreds, numbers_small tens, numbers_small ones
LIMIT 1000000;


###### populate it with days
INSERT INTO dates_dim (`date`)
SELECT  DATE_ADD( '{$from}', INTERVAL number DAY )
  FROM numbers
  WHERE DATE_ADD( '{$from}', INTERVAL number DAY ) BETWEEN '{$from}' AND '{$to}'
  ORDER BY number;

###### fill in other rows
UPDATE dates_dim SET
  timestamp =   UNIX_TIMESTAMP(date),
  day_of_week = DATE_FORMAT( date, "%W" ),
  weekend =     IF( DATE_FORMAT( date, "%W" ) IN ('Saturday','Sunday'), 'Weekend', 'Weekday'),
  month =       DATE_FORMAT( date, "%M"),
  year =        DATE_FORMAT( date, "%Y" ),
  month_day =   DATE_FORMAT( date, "%d" );

UPDATE dates_dim SET week_starting_monday = DATE_FORMAT(date,'%v');

DROP TABLE numbers;
DROP TABLE numbers_small;
EOT;

        DB::unprepared($sql);
    }
}
