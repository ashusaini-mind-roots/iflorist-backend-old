<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;

class WeeksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*$from = 2016;
        $to = 2030;
        $sql = 'INSERT INTO `weeks` (`number`,`year`,created_at,updated_at)values';
        for ($y = $from; $y <= $to; $y++) {
            for ($w = 1; $w <= 52; $w++) {
                $w = $w < 10 ? '0' . $w : $w;
                $sql .= $y == $to && $w == 52 ? "('$w',$y,now(),now());" : "('$w',$y,now(),now()),";
            }
        }
        DB::unprepared($sql);*/
    }
}
