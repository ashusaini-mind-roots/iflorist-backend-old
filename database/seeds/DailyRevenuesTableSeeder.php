<?php

use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;

class DailyRevenuesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sql = <<<EOT
        
insert into daily_revenues(store_week_id,dates_dim_date,user_id,amt,entered_date,created_at,updated_at)
SELECT 
     sw.id AS StoreWeekID,
    dd.`date` as dates_dim_date,
    1 as user_id,
    0 as amt,
     dd.`date` as entered_date,
     now() as created_at,
     now() as updated_at
FROM
    dates_dim dd
        INNER JOIN
    weeks w ON CASE
        WHEN dd.week_starting_monday = 53 THEN 52
        ELSE dd.week_starting_monday
    END = w.`number`
        AND dd.week_year = w.`year`
        INNER JOIN
    store_week sw ON w.id = sw.week_id
;

DROP TABLE IF EXISTS `daily_revenue_temp`;
CREATE TABLE `daily_revenue_temp` (
  `date_id` date NOT NULL,
  `amt` decimal(10,2) NOT NULL DEFAULT '0.00',
  `store_id` int(11) NOT NULL,
  `entered_by` int(11) NOT NULL,
  `entered_date` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`date_id`)
) ;

--
-- Dumping data for table `daily_revenue_temp`
--
INSERT INTO `daily_revenue_temp` VALUES 
('2016-07-03',4496.00,3,1,now()),
('2016-07-10',5774.00,3,1,now()),
('2016-07-17',4740.00,3,1,now()),
('2016-07-24',5337.00,3,1,now()),
('2016-07-31',7261.00,3,1,now()),
('2016-08-07',4780.00,3,1,now()),
('2016-08-14',6465.00,3,1,now()),
('2016-08-21',8082.00,3,1,now()),
('2016-08-28',6152.00,3,1,now()),
('2016-09-04',5222.00,3,1,now()),
('2016-09-11',7411.00,3,1,now()),
('2016-09-18',8700.00,3,1,now()),
('2016-09-25',8027.00,3,1,now()),
('2016-10-02',3432.00,3,1,now()),
('2016-10-09',13246.00,3,1,now()),
('2016-10-16',8011.00,3,1,now()),
('2016-10-23',7605.00,3,1,now()),
('2016-10-30',12848.00,3,1,now()),
('2016-11-06',8497.00,3,1,now()),
('2016-11-13',10979.00,3,1,now()),
('2016-11-20',13597.00,3,1,now()),
('2016-11-27',11731.00,3,1,now()),
('2016-12-04',12778.00,3,1,now()),
('2016-12-11',16685.00,3,1,now()),
('2016-12-18',32748.00,3,1,now()),
('2016-12-25',11811.00,3,1,now()),
('2017-01-08',8539.00,3,1,now()),
('2017-01-15',10882.00,3,1,now()),
('2017-01-22',8839.00,3,1,now()),
('2017-01-29',9141.00,3,1,now()),
('2017-02-05',11540.00,3,1,now()),
('2017-02-12',11597.00,3,1,now()),
('2017-02-19',50010.00,3,1,now()),
('2017-02-26',8026.00,3,1,now()),
('2017-03-05',14370.00,3,1,now()),
('2017-03-12',10215.00,3,1,now()),
('2017-03-19',10290.00,3,1,now()),
('2017-03-26',9001.00,3,1,now()),
('2017-04-02',11984.00,3,1,now()),
('2017-04-09',10678.00,3,1,now()),
('2017-04-16',21620.00,3,1,now()),
('2017-04-23',9961.00,3,1,now()),
('2017-04-30',9600.00,3,1,now()),
('2017-05-07',8225.00,3,1,now()),
('2017-05-14',46459.00,3,1,now()),
('2017-05-21',6467.00,3,1,now()),
('2017-05-28',5328.00,3,1,now()),
('2017-06-04',4059.00,3,1,now()),
('2017-06-11',5591.00,3,1,now()),
('2017-06-18',6909.00,3,1,now()),
('2017-06-25',5411.00,3,1,now()),
('2017-07-02',5535.00,3,1,now()),
('2017-07-09',4894.00,3,1,now()),
('2017-07-16',5761.00,3,1,now()),
('2017-07-23',12060.00,3,1,now()),
('2017-07-30',4985.00,3,1,now()),
('2017-08-06',6293.00,3,1,now()),
('2017-08-13',6789.00,3,1,now()),
('2017-08-20',7039.00,3,1,now()),
('2017-08-27',5488.00,3,1,now()),
('2017-09-03',6804.00,3,1,now()),
('2017-09-10',1100.00,3,1,now()),
('2017-09-17',4603.00,3,1,now()),
('2017-09-24',7586.00,3,1,now()),
('2017-10-01',4200.00,3,1,now()),
('2017-10-08',10074.00,3,1,now()),
('2017-10-15',7034.00,3,1,now()),
('2017-10-22',13098.00,3,1,now()),
('2017-10-29',14111.00,3,1,now()),
('2017-11-05',11686.00,3,1,now()),
('2017-11-12',14400.00,3,1,now()),
('2017-11-19',15848.00,3,1,now()),
('2017-11-26',16528.00,3,1,now()),
('2017-12-03',13080.00,3,1,now()),
('2017-12-10',12646.00,3,1,now()),
('2017-12-17',18500.00,3,1,now()),
('2017-12-24',35016.00,3,1,now()),
('2017-12-31',10500.00,3,1,now()),
('2018-01-01',0.00,3,1,now()),
('2018-01-02',1305.00,3,1,now()),
('2018-01-03',959.00,3,1,now()),
('2018-01-04',2142.00,3,1,now()),
('2018-01-05',1486.00,3,1,now()),
('2018-01-06',1372.00,3,1,now()),
('2018-01-07',0.00,3,1,now()),
('2018-01-08',1080.00,3,1,now()),
('2018-01-09',938.00,3,1,now()),
('2018-01-10',1904.00,3,1,now()),
('2018-01-11',1675.00,3,1,now()),
('2018-01-12',2553.00,3,1,now()),
('2018-01-13',2652.00,3,1,now()),
('2018-01-14',0.00,3,1,now()),
('2018-01-15',1343.00,3,1,now()),
('2018-01-16',2701.00,3,1,now()),
('2018-01-17',2100.00,3,1,now()),
('2018-01-18',787.00,3,1,now()),
('2018-01-19',1797.00,3,1,now()),
('2018-01-20',1139.00,3,1,now()),
('2018-01-21',0.00,3,1,now()),
('2018-01-22',1092.00,3,1,now()),
('2018-01-23',1397.00,3,1,now()),
('2018-01-24',1565.00,3,1,now()),
('2018-01-25',1596.00,3,1,now()),
('2018-01-26',2511.00,3,1,now()),
('2018-01-27',1777.00,3,1,now()),
('2018-01-28',0.00,3,1,now()),
('2018-01-29',1032.00,3,1,now()),
('2018-01-30',1389.00,3,1,now()),
('2018-01-31',1265.00,3,1,now()),
('2018-02-01',1825.00,3,1,now()),
('2018-02-02',2845.00,3,1,now()),
('2018-02-03',4221.00,3,1,now()),
('2018-02-04',0.00,3,1,now()),
('2018-02-05',2006.00,3,1,now()),
('2018-02-06',1381.00,3,1,now()),
('2018-02-07',1380.00,3,1,now()),
('2018-02-08',1544.00,3,1,now()),
('2018-02-09',3013.00,3,1,now()),
('2018-02-10',2227.00,3,1,now()),
('2018-02-11',193.00,3,1,now()),
('2018-02-12',2753.00,3,1,now()),
('2018-02-13',12736.00,3,1,now()),
('2018-02-14',35412.00,3,1,now()),
('2018-02-15',2509.00,3,1,now()),
('2018-02-16',2701.00,3,1,now()),
('2018-02-17',2976.00,3,1,now()),
('2018-02-18',0.00,3,1,now()),
('2018-02-19',1202.00,3,1,now()),
('2018-02-20',2044.00,3,1,now()),
('2018-02-21',1688.00,3,1,now()),
('2018-02-22',2031.00,3,1,now()),
('2018-02-23',2899.00,3,1,now()),
('2018-02-24',2079.00,3,1,now()),
('2018-02-25',0.00,3,1,now()),
('2018-02-26',850.00,3,1,now()),
('2018-02-27',3106.00,3,1,now()),
('2018-02-28',2804.00,3,1,now()),
('2018-03-01',2097.00,3,1,now()),
('2018-03-02',4090.00,3,1,now()),
('2018-03-03',2567.00,3,1,now()),
('2018-03-04',0.00,3,1,now()),
('2018-03-05',1395.00,3,1,now()),
('2018-03-06',1267.00,3,1,now()),
('2018-03-07',1039.00,3,1,now()),
('2018-03-08',2859.00,3,1,now()),
('2018-03-09',2100.00,3,1,now()),
('2018-03-10',1640.00,3,1,now()),
('2018-03-11',0.00,3,1,now()),
('2018-03-12',1199.00,3,1,now()),
('2018-03-13',2384.00,3,1,now()),
('2018-03-14',1855.00,3,1,now()),
('2018-03-15',1200.00,3,1,now()),
('2018-03-16',2291.00,3,1,now()),
('2018-03-17',2613.00,3,1,now()),
('2018-03-18',880.00,3,1,now()),
('2018-03-19',2761.00,3,1,now()),
('2018-03-20',1541.00,3,1,now()),
('2018-03-21',1589.00,3,1,now()),
('2018-03-22',1077.00,3,1,now()),
('2018-03-23',2371.00,3,1,now()),
('2018-03-24',2771.00,3,1,now()),
('2018-03-25',0.00,3,1,now()),
('2018-03-26',1144.00,3,1,now()),
('2018-03-27',2801.00,3,1,now()),
('2018-03-28',3255.00,3,1,now()),
('2018-03-29',3299.00,3,1,now()),
('2018-03-30',5629.10,3,1,now()),
('2018-03-31',7452.88,3,1,now()),
('2018-04-01',0.00,3,1,now()),
('2018-04-02',1690.00,3,1,now()),
('2018-04-03',1922.00,3,1,now()),
('2018-04-04',1399.00,3,1,now()),
('2018-04-05',1805.00,3,1,now()),
('2018-04-06',2034.00,3,1,now()),
('2018-04-07',2473.00,3,1,now()),
('2018-04-08',0.00,3,1,now()),
('2018-04-09',1665.00,3,1,now()),
('2018-04-10',2652.00,3,1,now()),
('2018-04-11',870.00,3,1,now()),
('2018-04-12',1778.00,3,1,now()),
('2018-04-13',6688.00,3,1,now()),
('2018-04-14',4524.00,3,1,now()),
('2018-04-15',0.00,3,1,now()),
('2018-04-16',1515.00,3,1,now()),
('2018-04-17',540.00,3,1,now()),
('2018-04-18',1254.00,3,1,now()),
('2018-04-19',1728.00,3,1,now()),
('2018-04-20',1759.00,3,1,now()),
('2018-04-21',2460.00,3,1,now()),
('2018-04-22',0.00,3,1,now()),
('2018-04-23',1051.00,3,1,now()),
('2018-04-24',1812.00,3,1,now()),
('2018-04-25',1962.00,3,1,now()),
('2018-04-26',2668.00,3,1,now()),
('2018-04-27',1507.00,3,1,now()),
('2018-04-28',2038.00,3,1,now()),
('2018-04-29',0.00,3,1,now()),
('2018-04-30',1435.00,3,1,now()),
('2018-05-01',1756.00,3,1,now()),
('2018-05-02',1143.00,3,1,now()),
('2018-05-03',2270.00,3,1,now()),
('2018-05-04',1662.00,3,1,now()),
('2018-05-05',1911.00,3,1,now()),
('2018-05-06',0.00,3,1,now()),
('2018-05-07',1623.00,3,1,now()),
('2018-05-08',2170.00,3,1,now()),
('2018-05-09',1660.00,3,1,now()),
('2018-05-10',2534.00,3,1,now()),
('2018-05-11',10541.00,3,1,now()),
('2018-05-12',26488.00,3,1,now()),
('2018-05-13',13230.00,3,1,now()),
('2018-05-14',1925.00,3,1,now()),
('2018-05-15',1926.00,3,1,now()),
('2018-05-16',1340.00,3,1,now()),
('2018-05-17',1308.00,3,1,now()),
('2018-05-18',1075.00,3,1,now()),
('2018-05-19',1410.00,3,1,now()),
('2018-05-20',0.00,3,1,now()),
('2018-05-21',456.00,3,1,now()),
('2018-05-22',1099.00,3,1,now()),
('2018-05-23',1109.00,3,1,now()),
('2018-05-24',1481.00,3,1,now()),
('2018-05-25',2894.00,3,1,now()),
('2018-05-26',655.00,3,1,now()),
('2018-05-27',0.00,3,1,now()),
('2018-05-28',0.00,3,1,now()),
('2018-05-29',922.00,3,1,now()),
('2018-05-30',1330.00,3,1,now()),
('2018-05-31',940.00,3,1,now()),
('2018-06-01',1390.00,3,1,now()),
('2018-06-02',2048.00,3,1,now()),
('2018-06-03',0.00,3,1,now()),
('2018-06-04',851.00,3,1,now()),
('2018-06-05',1572.00,3,1,now()),
('2018-06-06',245.00,3,1,now()),
('2018-06-07',476.00,3,1,now()),
('2018-06-08',1093.00,3,1,now()),
('2018-06-09',1663.00,3,1,now()),
('2018-06-10',0.00,3,1,now()),
('2018-06-11',766.00,3,1,now()),
('2018-06-12',1177.00,3,1,now()),
('2018-06-13',948.00,3,1,now()),
('2018-06-14',695.00,3,1,now()),
('2018-06-15',1585.00,3,1,now()),
('2018-06-16',1644.00,3,1,now()),
('2018-06-17',0.00,3,1,now()),
('2018-06-18',374.00,3,1,now()),
('2018-06-19',1377.00,3,1,now()),
('2018-06-20',730.00,3,1,now()),
('2018-06-21',577.00,3,1,now()),
('2018-06-22',1520.00,3,1,now()),
('2018-06-23',1135.00,3,1,now()),
('2018-06-24',0.00,3,1,now()),
('2018-06-25',770.00,3,1,now()),
('2018-06-26',469.00,3,1,now()),
('2018-06-27',912.00,3,1,now()),
('2018-06-28',815.00,3,1,now()),
('2018-06-29',1142.00,3,1,now()),
('2018-06-30',725.00,3,1,now()),
('2018-07-01',0.00,3,1,now()),
('2018-07-02',656.00,3,1,now()),
('2018-07-03',749.00,3,1,now()),
('2018-07-04',0.00,3,1,now()),
('2018-07-05',492.00,3,1,now()),
('2018-07-06',800.00,3,1,now()),
('2018-07-07',726.00,3,1,now()),
('2018-07-08',0.00,3,1,now()),
('2018-07-09',431.00,3,1,now()),
('2018-07-10',451.00,3,1,now()),
('2018-07-11',375.00,3,1,now()),
('2018-07-12',472.00,3,1,now()),
('2018-07-13',874.00,3,1,now()),
('2018-07-14',1282.00,3,1,now()),
('2018-07-15',0.00,3,1,now()),
('2018-07-16',870.00,3,1,now()),
('2018-07-17',419.00,3,1,now()),
('2018-07-18',1254.00,3,1,now()),
('2018-07-19',1295.00,3,1,now()),
('2018-07-20',1069.00,3,1,now()),
('2018-07-21',973.00,3,1,now()),
('2018-07-22',0.00,3,1,now()),
('2018-07-23',898.00,3,1,now()),
('2018-07-24',980.00,3,1,now()),
('2018-07-25',1258.00,3,1,now()),
('2018-07-26',1285.00,3,1,now()),
('2018-07-27',1482.00,3,1,now()),
('2018-07-28',0.00,3,1,now()),
('2018-07-29',0.00,3,1,now()),
('2018-07-30',710.00,3,1,now()),
('2018-07-31',722.00,3,1,now()),
('2018-08-01',455.00,3,1,now()),
('2018-08-02',1270.00,3,1,now()),
('2018-08-03',1067.00,3,1,now()),
('2018-08-04',1283.00,3,1,now()),
('2018-08-05',0.00,3,1,now()),
('2018-08-06',1015.00,3,1,now()),
('2018-08-07',885.00,3,1,now()),
('2018-08-08',762.00,3,1,now()),
('2018-08-09',845.00,3,1,now()),
('2018-08-10',952.00,3,1,now()),
('2018-08-11',1650.00,3,1,now()),
('2018-08-12',0.00,3,1,now()),
('2018-08-13',1178.00,3,1,now()),
('2018-08-14',632.00,3,1,now()),
('2018-08-15',1000.00,3,1,now()),
('2018-08-16',985.00,3,1,now()),
('2018-08-17',1226.00,3,1,now()),
('2018-08-18',839.00,3,1,now()),
('2018-08-19',0.00,3,1,now()),
('2018-08-20',637.00,3,1,now()),
('2018-08-21',917.00,3,1,now()),
('2018-08-22',900.00,3,1,now()),
('2018-08-23',865.00,3,1,now()),
('2018-08-24',2526.00,3,1,now()),
('2018-08-25',190.00,3,1,now()),
('2018-08-26',0.00,3,1,now()),
('2018-08-27',992.00,3,1,now()),
('2018-08-28',736.00,3,1,now()),
('2018-08-29',1192.00,3,1,now()),
('2018-08-30',1209.00,3,1,now()),
('2018-08-31',966.00,3,1,now()),
('2018-09-01',1138.00,3,1,now()),
('2018-09-02',0.00,3,1,now()),
('2018-09-03',0.00,3,1,now()),
('2018-09-04',900.00,3,1,now()),
('2018-09-05',1055.00,3,1,now()),
('2018-09-06',943.00,3,1,now()),
('2018-09-07',1009.00,3,1,now()),
('2018-09-08',1455.00,3,1,now()),
('2018-09-09',0.00,3,1,now()),
('2018-09-10',1048.00,3,1,now()),
('2018-09-11',1582.00,3,1,now()),
('2018-09-12',1047.00,3,1,now()),
('2018-09-13',2865.00,3,1,now()),
('2018-09-14',1183.00,3,1,now()),
('2018-09-15',1403.00,3,1,now()),
('2018-09-16',325.00,3,1,now()),
('2018-09-17',821.00,3,1,now()),
('2018-09-18',663.00,3,1,now()),
('2018-09-19',1068.00,3,1,now()),
('2018-09-20',1831.00,3,1,now()),
('2018-09-21',1266.00,3,1,now()),
('2018-09-22',1060.00,3,1,now()),
('2018-09-23',0.00,3,1,now()),
('2018-09-24',997.00,3,1,now()),
('2018-09-25',1491.00,3,1,now()),
('2018-09-26',1005.00,3,1,now()),
('2018-09-27',1235.00,3,1,now()),
('2018-09-28',2669.00,3,1,now()),
('2018-09-29',844.00,3,1,now()),
('2018-09-30',0.00,3,1,now()),
('2018-10-01',841.00,3,1,now()),
('2018-10-02',1297.00,3,1,now()),
('2018-10-03',740.00,3,1,now()),
('2018-10-04',1338.00,3,1,now()),
('2018-10-05',840.00,3,1,now()),
('2018-10-06',1374.00,3,1,now()),
('2018-10-07',0.00,3,1,now()),
('2018-10-08',862.00,3,1,now()),
('2018-10-09',1561.00,3,1,now()),
('2018-10-10',1253.00,3,1,now()),
('2018-10-11',1673.00,3,1,now()),
('2018-10-12',1711.00,3,1,now()),
('2018-10-13',1417.00,3,1,now()),
('2018-10-14',0.00,3,1,now()),
('2018-10-15',709.00,3,1,now()),
('2018-10-16',1202.00,3,1,now()),
('2018-10-17',3165.00,3,1,now()),
('2018-10-18',913.00,3,1,now()),
('2018-10-19',2107.00,3,1,now()),
('2018-10-20',1428.00,3,1,now()),
('2018-10-21',0.00,3,1,now()),
('2018-10-22',635.00,3,1,now()),
('2018-10-23',2082.00,3,1,now()),
('2018-10-24',1217.00,3,1,now()),
('2018-10-25',1122.00,3,1,now()),
('2018-10-26',1504.00,3,1,now()),
('2018-10-27',2548.00,3,1,now()),
('2018-10-28',0.00,3,1,now()),
('2018-10-29',1592.00,3,1,now()),
('2018-10-30',1570.00,3,1,now()),
('2018-10-31',4728.00,3,1,now()),
('2018-11-01',1668.00,3,1,now()),
('2018-11-02',2413.00,3,1,now()),
('2018-11-03',1074.00,3,1,now()),
('2018-11-04',0.00,3,1,now()),
('2018-11-05',1005.00,3,1,now()),
('2018-11-06',1920.00,3,1,now()),
('2018-11-07',1082.00,3,1,now()),
('2018-11-08',1785.00,3,1,now()),
('2018-11-09',3208.00,3,1,now()),
('2018-11-10',617.00,3,1,now()),
('2018-11-11',0.00,3,1,now()),
('2018-11-12',943.00,3,1,now()),
('2018-11-13',1498.00,3,1,now()),
('2018-11-14',967.00,3,1,now()),
('2018-11-15',1680.00,3,1,now()),
('2018-11-16',1724.00,3,1,now()),
('2018-11-17',5290.00,3,1,now()),
('2018-11-18',0.00,3,1,now()),
('2018-11-19',1548.00,3,1,now()),
('2018-11-20',2507.00,3,1,now()),
('2018-11-21',10602.00,3,1,now()),
('2018-11-22',1215.00,3,1,now()),
('2018-11-23',862.00,3,1,now()),
('2018-11-24',1623.00,3,1,now()),
('2018-11-25',0.00,3,1,now()),
('2018-11-26',753.00,3,1,now()),
('2018-11-27',1292.00,3,1,now()),
('2018-11-28',1016.00,3,1,now()),
('2018-11-29',1798.00,3,1,now()),
('2018-11-30',2370.00,3,1,now()),
('2018-12-01',2835.00,3,1,now()),
('2018-12-02',0.00,3,1,now()),
('2018-12-03',2341.00,3,1,now()),
('2018-12-04',3827.00,3,1,now()),
('2018-12-05',1869.00,3,1,now()),
('2018-12-06',1982.00,3,1,now()),
('2018-12-07',2072.00,3,1,now()),
('2018-12-08',3026.00,3,1,now()),
('2018-12-09',0.00,3,1,now()),
('2018-12-10',6275.00,3,1,now()),
('2018-12-11',1888.00,3,1,now()),
('2018-12-12',1106.00,3,1,now()),
('2018-12-13',15232.00,3,1,now()),
('2018-12-14',2542.00,3,1,now()),
('2018-12-15',3498.00,3,1,now()),
('2018-12-16',0.00,3,1,now()),
('2018-12-17',2221.00,3,1,now()),
('2018-12-18',4743.00,3,1,now()),
('2018-12-19',3517.00,3,1,now()),
('2018-12-20',2821.00,3,1,now()),
('2018-12-21',10730.00,3,1,now()),
('2018-12-22',5916.00,3,1,now()),
('2018-12-23',3660.00,3,1,now()),
('2018-12-24',8510.00,3,1,now()),
('2018-12-25',0.00,3,1,now()),
('2018-12-26',1851.00,3,1,now()),
('2018-12-27',2740.00,3,1,now()),
('2018-12-28',1371.00,3,1,now()),
('2018-12-29',4079.00,3,1,now()),
('2018-12-30',0.00,3,1,now()),
('2018-12-31',6525.00,3,1,now())
;
        

UPDATE daily_revenues target_table
        INNER JOIN
    (SELECT 
        dr.id, drt.date_id, drt.amt, sw.id AS StoreWeekID
    FROM
        daily_revenue_temp drt
    INNER JOIN dates_dim dd ON drt.date_id = dd.`date`
    INNER JOIN weeks w ON CASE
        WHEN dd.week_starting_monday = 53 THEN 52
        ELSE dd.week_starting_monday
    END = w.`number`
        AND dd.week_year = w.`year`
    INNER JOIN store_week sw ON w.id = sw.week_id AND sw.store_id = 3
    INNER JOIN daily_revenues dr ON sw.id = dr.store_week_id
        AND dr.dates_dim_date = drt.date_id) source_table ON target_table.id = source_table.id 
SET 
    target_table.amt = source_table.amt;

DROP TABLE IF EXISTS `daily_revenue_temp`;
    
EOT;
        DB::unprepared($sql);

    }
}
