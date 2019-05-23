<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InvoiceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sql = <<<EOT
DROP TABLE IF EXISTS `invoice_temp`;
CREATE TABLE `invoice_temp` (
    `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
    `invoice_name` VARCHAR(150) NOT NULL,
    `invoice_amt` DECIMAL(10 , 2 ) NOT NULL DEFAULT '0.00',
    `invoice_date` DATE NOT NULL,
    PRIMARY KEY (`id`)
);
-- Populating Data
Insert into invoice_temp(`invoice_name`,`invoice_amt`, `invoice_date`)values
('peterson',17.50,'2018-01-01'),('peterson',78.50,'2018-01-01'),('Lonnie',127.50,'2018-01-01'),('Supernat.',54.00,'2018-01-01'),('19-1066',47.25,'2018-01-01'),('19-1067',15.95,'2018-01-01'),('19.1061',432.69,'2018-01-01'),('173321 PALM BEACH WH',34.30,'2018-01-01'),('TROPICAL',114.00,'2018-01-01'),('19-1069',35.92,'2018-01-08'),('19-1068',673.00,'2018-01-08'),('19-1070 bucket truck',58.02,'2018-01-08'),('80458 RICHARDSON',16.00,'2018-01-08'),('043195 KIRK & COMPANY',32.00,'2018-01-08'),('19-1071',304.75,'2018-01-08'),('deducted 19-1068  $96 transf',-96.00,'2018-01-08'),('TROPICAL',95.00,'2018-01-08'),('p168868 peterson',45.50,'2018-01-08'),('4300 lonnie mills',96.25,'2018-01-08'),('19-1072 bucket truck',41.85,'2018-01-08'),('19-1073',178.85,'2018-01-08'),('173659 PBG whole sale',34.75,'2018-01-08'),('19-1074',135.85,'2018-01-08'),('80491',38.50,'2018-01-08'),('168910',19.00,'2018-01-08'),('173827 PBG WHOLE SALE',38.65,'2018-01-08'),('43214',25.00,'2018-01-08'),('5791',78.00,'2018-01-08'),('kirk & comp 043214',25.00,'2018-01-15'),('19-1076',1183.95,'2018-01-15'),('043214 deducted trans to DW',-12.50,'2018-01-15'),('80491',38.50,'2018-01-15'),('5791',78.00,'2018-01-15'),('168910 PETERSON',19.00,'2018-01-15'),('10-1077 bucket truck',89.27,'2018-01-15'),('19-1078 bucket truck',63.50,'2018-01-15'),('GARDEN DESIGNS 117034',136.65,'2018-01-15'),('super natural 15636',97.00,'2018-01-15'),('arthur peter 166879',22.50,'2018-01-15'),('19-1081',42.90,'2018-01-15'),('19-1080',1126.76,'2018-01-22'),('64 blooming freedon',68.00,'2018-01-22'),('peterson 166924',7.50,'2018-01-22'),('174581',19.25,'2018-01-22'),('SUPERNATURAL 15667',227.50,'2018-01-22'),('bucket truck 01/25 19-1048',40.70,'2018-01-22'),('GARDEN DESINGS 117126',217.50,'2018-01-29'),('KIRK & COM 843100',31.00,'2018-01-29'),('19-1083',895.14,'2018-01-29'),('19-1086',209.97,'2018-01-29'),('RICHARDSON 80606',45.00,'2018-01-29'),('LONNIE MILLS 5954',60.75,'2018-01-29'),('N&N ORCHIDS  201219',29.64,'2018-01-29'),('LONNIE MILLS 5971',12.50,'2018-01-29'),('bucket truck 191088',64.30,'2018-01-29'),('PALM BEACH WHOLESALE',201.75,'2018-01-29'),(' kirk & company',47.50,'2018-02-05'),('GARDEN DESIGN 117311',94.25,'2018-02-05'),('P B WHOLE SALE 176031',82.50,'2018-02-05'),('N&N ORCHIDS 2175',41.60,'2018-02-05'),('BUCKET TRUCK 10-1093',135.87,'2018-02-05'),('BUCKET TRUCK 10-1092',92.45,'2018-02-05'),('19-1089',896.58,'2018-02-05'),('19-1091',649.60,'2018-02-05'),('SUPER NATURAL 15753',283.00,'2018-02-05'),('P B WHOLE SALES  176384',43.75,'2018-02-05'),('201747',41.60,'2018-02-05'),('175959',91.48,'2018-02-05'),('80636',522.00,'2018-02-05'),('169084',42.50,'2018-02-05'),('169056',101.00,'2018-02-05'),('richardson ferneries 80636',522.00,'2018-02-12'),('SUPER NATURAL 15753',181.50,'2018-02-12'),('BUCKET TRUCK 191094',182.00,'2018-02-12'),('bucket truck 02/12 19-1089',168.30,'2018-02-12'),('buchet truck 14th 19-1097',217.75,'2018-02-12'),('LONNIE MILLS 6027',231.50,'2018-02-12'),('PETERSON 166982',268.50,'2018-02-12'),('PETERSON 169056',101.00,'2018-02-12'),('N&N 176384',43.75,'2018-02-12'),('P B WHOLE SALE 177169',20.60,'2018-02-12'),('19.1062',5731.69,'2018-02-12'),('19-1063',1086.50,'2018-02-12'),('3914',2044.20,'2018-02-12'),('N&N 202193',72.80,'2018-02-12'),('richardson 80672',183.50,'2018-02-12'),('19-1099 $',620.00,'2018-02-19'),('richardson 80706',76.50,'2018-02-19'),('PETERSON 167044',82.00,'2018-02-19'),('LONNIE MILLS 5055',67.00,'2018-02-19'),('N&N ORCH 202607',19.76,'2018-02-19'),('GARDEN DESIGN 117326',75.30,'2018-02-19'),('PETERSON 167069',35.00,'2018-02-19'),('PB WHOLE SALE 177675',79.85,'2018-02-19'),('BUCKET TRUCK 19-1102',47.60,'2018-02-19'),('bucket truck 22nd 16-1101',100.70,'2018-02-19'),('19-1104 BUCKET',41.62,'2018-02-19'),('19-1102 BUCKET',47.60,'2018-02-19'),('19-1101 BUCKET',100.70,'2018-02-19'),('173217',100.50,'2018-02-19'),('6821',243.00,'2018-02-19'),('225150',33.28,'2018-02-19'),('17772',312.50,'2018-02-19'),('203727',116.60,'2018-02-19'),('203592',255.75,'2018-02-19'),('KIRK & COM 843235',24.00,'2018-02-26'),('fresh market',32.07,'2018-02-26'),('lonnie 5125',92.00,'2018-02-26'),('ep rich',183.50,'2018-02-26'),('178585',45.70,'2018-02-26'),('bucket truck 19-1107',204.85,'2018-02-26'),('richadson 80736',80.00,'2018-02-26'),('lonnie mills 5104',99.00,'2018-02-26'),('peterson 167109',25.25,'2018-02-26'),('19-1103',975.15,'2018-02-26'),('LOnnie mills 5114',122.70,'2018-02-26'),('GARDEN DESIGNS 117523',35.90,'2018-02-26'),('PB WHOLE SALE 178205',72.65,'2018-02-26'),('SUPER NATURAL 15882',76.00,'2018-02-26'),('19-1109',1162.77,'2018-02-26'),('bucket truck 191108',102.72,'2018-02-26'),('bucket ruck 19-1110',94.01,'2018-02-26'),('fresh market 01286j',103.63,'2018-02-26'),('19-1109',1188.27,'2018-03-05'),('RICHARSON 81170',42.00,'2018-03-05'),('KIRK & COM',48.50,'2018-03-05'),('BUCKET TRUCK 19-1111',60.00,'2018-03-05'),('19-1112',190.00,'2018-03-05'),('BUCKET TRUCK 19-1113',137.10,'2018-03-05'),('PETERSON 168316',17.50,'2018-03-05'),('P B WHOLE SALE 178836',27.80,'2018-03-05'),('GARDEN DESIGN 117629',55.85,'2018-03-05'),('SUPER NATURAL 15911',94.00,'2018-03-05'),('trans to DW 19-1109',-39.95,'2018-03-05'),('trans to DW garden d 117629',-25.00,'2018-03-05'),('fresh market',20.31,'2018-03-05'),('bucket truck 3/9 19-1118',12.45,'2018-03-05'),('RICHARDSON 82551',41.00,'2018-03-19'),('KIRK & COMP 942687',55.00,'2018-03-19'),('SUPER NATURAL 15968',93.00,'2018-03-19'),('PETERSON 168427',18.00,'2018-03-19'),(' PETERSON 168457',69.00,'2018-03-19'),('P B WHOLE SALE 180204',173.90,'2018-03-19'),('19-1122',537.75,'2018-03-19'),('19-1124',487.78,'2018-03-19'),('19-1125',383.45,'2018-03-19'),('P B  WHOLE SALE',158.00,'2018-03-26'),('19-1126',30.00,'2018-03-26'),('19-1127',170.62,'2018-03-26'),('19-1117',2551.84,'2018-03-26'),('P B  WHOLE SALE 181093',569.15,'2018-03-26'),('FRESH MARKET 05324J',20.31,'2018-03-26'),('IDLE HOURS',150.00,'2018-03-26'),('PETERSON 169811',107.25,'2018-03-26'),('LONNIE MILLS 6111',117.50,'2018-03-26'),('GIVERNY GARDEN',76.87,'2018-03-26'),('KIRK & COMPANY $85 for chruch',223.50,'2018-03-26'),('SUPET NATURALS 16047',94.00,'2018-03-26'),('PETERSON 169811',107.25,'2018-03-26'),('PETERSON169778',130.00,'2018-03-26'),('GARDEN DESIGN 117881 $1,126.20 FOR CHURCH',0.01,'2018-03-26'),('RICHARDSON 82583',104.50,'2018-03-26'),('N&N ORCHID 204304',82.99,'2018-03-26'),('KINGS WHOLESALE $2,202.44',0.01,'2018-03-26'),('FRESH MARCKET',16.04,'2018-03-26'),('BUCKET TRUCK 191129',131.98,'2018-04-02'),('LONNIE MILLS 6218',83.00,'2018-04-02'),('RICHARDSON 81202',32.50,'2018-04-02'),('PETERSON 169840',66.50,'2018-04-02'),('garden design 118081',144.70,'2018-04-02'),('super natural 16080',108.00,'2018-04-02'),('GAEDEN DESIGNS 118081',81.20,'2018-04-02'),('N&N 205168',30.26,'2018-04-02'),('PETERSON 168475',34.00,'2018-04-02'),('LONNIE MILLS 6236',91.00,'2018-04-02'),('FRESH MARKET',11.76,'2018-04-02'),('Palm beach wholesale',17.75,'2018-04-09'),('Palm beach wholesale',67.20,'2018-04-09'),('GARDEN DESIGN 118135',134.65,'2018-04-09'),('N&N ORCHIDS 205682',9.46,'2018-04-09'),('BLOOMING FREEDON 409',102.00,'2018-04-09'),('RICHARSON 81232',48.50,'2018-04-09'),('PETERSON 168491',6.50,'2018-04-09'),('TROPICAL ORCHIDS 666364',522.00,'2018-04-09'),('trans toDW trpical orch 66636',-82.50,'2018-04-09'),('SUPER NATURAL 16109',104.00,'2018-04-09'),('LONNIE MILLS 5305',114.25,'2018-04-09'),('PETERSON 166827',23.50,'2018-04-09'),('P B WHOLE SALE 182227',63.85,'2018-04-09'),('19-1135',785.65,'2018-04-09'),('19-1139',303.13,'2018-04-09'),('182109',24.75,'2018-04-09'),('182109',44.00,'2018-04-09'),('PB WHOLE SALE 182266',22.50,'2018-04-09'),('FRESH MARKET',25.65,'2018-04-09'),('19-1141',1110.00,'2018-04-16'),('KIRK & CONM 042740',36.00,'2018-04-16'),('RICHARDSON 81263',125.00,'2018-04-16'),('PETERSON 170128',36.00,'2018-04-16'),('N&N 2175',19.97,'2018-04-16'),('PETERSON 170157',49.50,'2018-04-16'),('4465',78.20,'2018-04-16'),('FRESH MARKET',43.83,'2018-04-23'),('PETERSON 170199',66.00,'2018-04-23'),('LONNIE MILLS 5396',116.50,'2018-04-23'),('RICHARDSSONS 81294',72.00,'2018-04-23'),('PB WHOLESALE 183023',100.00,'2018-04-23'),('4475',375.74,'2018-04-23'),('4505',299.35,'2018-04-23'),('SUPERNATURAL 16163',134.50,'2018-04-23'),('P B WHOLE SALE 183092',133.55,'2018-04-23'),('GARDEN DESIGN 118754',224.43,'2018-04-23'),('PETRSON  170229',8.25,'2018-04-23'),('N&N ORCH 206670',30.89,'2018-04-23'),('KIRK &  COMP 042764',66.50,'2018-04-30'),('PETERSON 170284',101.00,'2018-04-30'),('RICHARDSON 81331',105.00,'2018-04-30'),('PB WHOLE SALE 183890',34.75,'2018-04-30'),('LONNIE  MILLS 5467',85.00,'2018-04-30'),('PETERSON 170311',58.50,'2018-04-30'),('SUPER NATURAL',96.00,'2018-04-30'),('N&N 20744',19.76,'2018-04-30'),('TROPICAL ORCHIDS 424116',599.00,'2018-05-07'),('RICHARDSON 82674',209.00,'2018-05-07'),('KIRK & COMP 042781',167.00,'2018-05-07'),('PETERSON 170351',131.00,'2018-05-07'),('FRESH MARKET #01668G',81.21,'2018-05-07'),('PALM BEACH #184568',226.80,'2018-05-07'),('PALM BEACH #184244',23.90,'2018-05-07'),('SUPERNATURALS #16217',84.50,'2018-05-07'),('N&N #207806',112.01,'2018-05-07'),('N&N #207913',19.76,'2018-05-07'),('N&N #207923',56.50,'2018-05-07'),('FRESH MARKET #846929',139.05,'2018-05-07'),('PETERSON 170380',484.00,'2018-05-07'),('LONNIE MILLS  5525',306.00,'2018-05-07'),('GARDEN DESINGS 118649',177.76,'2018-05-07'),('PALM BEACH 184456',145.40,'2018-05-07'),('PA LM BEACH 184619',217.55,'2018-05-07'),('PALM BEACH 184571',126.75,'2018-05-07'),('PALM BEACH 184567',164.75,'2018-05-07'),('19-1137',4434.40,'2018-05-07'),('846929',139.05,'2018-05-07'),('42781 kirk',167.00,'2018-05-07'),('4644',1232.20,'2018-05-07'),('4672',536.50,'2018-05-07'),('MFM PHONE ORDER',707.76,'2018-05-07'),('RICHARDSON 82703',42.00,'2018-05-14'),(' FRESHMARKET 07043G',32.08,'2018-05-14'),('FRESHMARKET 00663G',25.65,'2018-05-14'),('GARDEN DESIGN 0026',63.85,'2018-05-14'),('PETERSON 170446',42.50,'2018-05-14'),('4763',658.71,'2018-05-14'),('KIRK & COMP 042798',61.50,'2018-05-21'),('PETERSON 170477',18.75,'2018-05-21'),('RICHARDSON 82935',130.00,'2018-05-21'),('GARDEN DESIGN 0549',38.70,'2018-05-21'),('PETERSON 170247',53.75,'2018-05-21'),('PALM BEACH  #185521',391.85,'2018-05-21'),('PETERSON 170862',20.00,'2018-05-28'),('GARDEN DESIGNS 0069',13.95,'2018-05-28'),('N&N ORCHIDS 209351',20.28,'2018-05-28'),('SUPERNATURAL 16271',96.00,'2018-05-28'),('PETERSON 170889',71.25,'2018-05-28'),('4833',944.04,'2018-05-28'),('4875',97.50,'2018-05-28'),('RICHARDSON 82785',92.00,'2018-06-04'),('4888',730.25,'2018-06-04'),('PETERSON 170949',16.25,'2018-06-04'),('N&N ORCHIDS 209817',39.00,'2018-06-04'),('SUPER NATURAL 16298',67.00,'2018-06-04'),('KIRK & COMPANY 942673',46.00,'2018-03-12'),('richardson ferneries 82519',26.00,'2018-03-12'),('PETERSON 168362',26.75,'2018-03-12'),('P B WHOLE SALES 179468',23.80,'2018-03-12'),('19-1114',1101.00,'2018-03-12'),('19-1120',112.70,'2018-03-12'),('PETERSON 168386',50.00,'2018-03-12'),('LONNIE MILLS 5176',26.50,'2018-03-12'),('19-1121',151.75,'2018-03-12'),('P B WHOLE SALES 179804',108.00,'2018-03-12'),('PB WHOLE SALE 179747',187.15,'2018-03-12'),('4941',846.85,'2018-06-11'),('CHICHRDSON 83608',19.50,'2018-06-11'),('PB WHOLE SALE 186234',101.35,'2018-06-11'),('4941 CREDIT',-45.00,'2018-06-11'),('PETERSON 170779',29.75,'2018-06-11'),('GARDEN DESINGS 0157',196.50,'2018-06-11'),('N&N 210217',19.50,'2018-06-11'),('4970',109.95,'2018-06-11'),('4975',65.25,'2018-06-11'),('PB WHOLE SALE 186467',13.90,'2018-06-11'),('PB WHOLE SALE 186445',47.40,'2018-06-11'),('tropical orchids 596573',412.50,'2018-06-18'),('4990',855.57,'2018-06-18'),('4990 credit',-30.00,'2018-06-18'),('KIRK & COMPANY 249294',36.50,'2018-06-18'),('richardson 839735',21.00,'2018-06-18'),('peterson 169735',24.75,'2018-06-18'),('transferd 6 orch stem 210661',-6.00,'2018-06-18'),('peterson 170970',29.50,'2018-06-18'),('N&N ORCHIDS  210661',20.80,'2018-06-18'),('PB WHOLE SALE 186721',8.75,'2018-06-18'),('TRAS WD',-13.00,'2018-06-18'),('5033',871.00,'2018-06-25'),('5033 credit',-12.00,'2018-06-25'),('PB WHOLE SALE 186835',32.90,'2018-06-25'),('transf DW 5033 FLOWERS',-30.20,'2018-06-25'),('GARDEN DEIGNS 0256',90.80,'2018-06-25'),('5065',94.15,'2018-06-25'),('TRANS DW 5033',-9.00,'2018-06-25'),('TRANS DW PLANT & FLOWER',-21.00,'2018-06-25'),('5073',901.81,'2018-07-02'),('TRAS TO DW 5073',-15.00,'2018-07-02'),('TRANS TO DW 2 SUCULENT',-5.00,'2018-07-09'),('TRANS TO DW',-30.60,'2018-07-09'),('#5138',321.70,'2018-07-09'),('#5108',256.49,'2018-07-09'),('N&N 211838',9.88,'2018-07-09'),('FRESH MARKET',20.31,'2018-07-09'),('FRESH MARKET',26.73,'2018-07-09'),('kirk & company 290522',25.00,'2018-07-16'),('5154',641.66,'2018-07-16'),('RICHARDSON 83766',31.00,'2018-07-16'),('TRASNF DW 5154',-32.00,'2018-07-16'),('GARDEN DESINGS 0348',73.75,'2018-07-16'),('BUKET TRUCK 5697',111.85,'2018-07-16'),('SUPER NATURAL 16386',86.00,'2018-07-16'),('TRASNF DW 5154',-32.50,'2018-07-16'),('5197 BT',111.85,'2018-07-16'),('RICHARDSON 83793',21.50,'2018-07-23'),('PB WHOLE SALE 187996',27.40,'2018-07-23'),('pb whole s 188072 $47.35fresh21.80',21.80,'2018-07-23'),('peterson 171204',39.00,'2018-07-23'),('bucket truck 5232',120.40,'2018-07-23'),('TRANS DW PLANT / BASKET',-37.00,'2018-07-23'),('PB whole sale 188122',64.25,'2018-07-23'),('fresh marker',4.27,'2018-07-23'),('fresh marker',21.39,'2018-07-23'),('home depot ',127.25,'2018-07-23'),('5203',739.15,'2018-07-23'),('5226',77.50,'2018-07-23'),('TRI COUNTY 333863',42.25,'2018-07-30'),('KIRK & COM 290534',24.00,'2018-07-30'),('RICHARDSON 83822',69.50,'2018-07-30'),('PETERSONN 171045',10.00,'2018-07-30'),('BUCKET TRCU 5275',119.15,'2018-07-30'),('#5245',794.76,'2018-07-30'),('TRANS TO DW #5245',-35.00,'2018-07-30'),('FRSH MARKET',9.61,'2018-07-30'),('WHOLE FOODS FRESH',21.40,'2018-07-30'),('5285',666.46,'2018-08-06'),('FRESH MARKET',35.28,'2018-08-06'),('richardson 83846',32.00,'2018-08-06'),('bucket truck 5317',66.80,'2018-08-06'),('WHOLE FOODS FRESH',44.94,'2018-08-06'),('N&N 213450',19.76,'2018-08-06'),('PETERSON 171067',64.00,'2018-08-06'),('709518 TROPICAL ORCHIDS',370.00,'2018-08-06'),('TRI COUNTY 333760',56.00,'2018-08-13'),('#5330',742.75,'2018-08-13'),('RICHARDSON 83977',12.00,'2018-08-13'),('BP WHOLE SALE 188820',44.80,'2018-08-13'),('BP WHOLE SALE 188772',55.65,'2018-08-13'),('FRSH MARKET',11.76,'2018-08-13'),('WHOLE FOODS',34.24,'2018-08-13'),('FRSH MARKET',22.44,'2018-08-13'),('N&N ORHIDS  213914',9.88,'2018-08-13'),('FRESH AMRKET',20.31,'2018-08-13'),('5384',781.00,'2018-08-20'),('RICHARDSON 83858',36.50,'2018-08-20'),('PETERSON 170808',39.25,'2018-08-20'),('5407',82.45,'2018-08-20'),('KIRK & COMP 554014',23.00,'2018-08-27'),('FRESH MARKET',13.89,'2018-08-27'),('FRESH MARKET',20.31,'2018-08-27'),('5432',34.00,'2018-08-27'),('5429',443.00,'2018-08-27'),('RICHARDSON 83887',49.00,'2018-08-27'),('PB WHOLE SALE 189382',19.90,'2018-08-27'),('PETERSON 172437',39.00,'2018-08-27'),('GARDEN DESING I1476',82.60,'2018-08-27'),('PB WHOLE SALE 189497',69.75,'2018-08-27'),('PETERSON 172464',77.25,'2018-08-27'),('5463',262.91,'2018-08-27'),('5469',53.15,'2018-08-27'),('P B WHOLE SALE 189660',65.10,'2018-09-03'),('TRI COUNTY 936207',54.25,'2018-09-03'),('PETERSON 172493',13.50,'2018-09-03'),('5489',725.90,'2018-09-03'),('TRANS TO DW 5489',-37.12,'2018-09-03'),('BUCKET TRUCK 5525',281.00,'2018-09-03'),('PETERSON 174985',10.00,'2018-09-03'),('FRESH MARKET',17.10,'2018-09-10'),('RICHARDSON 83926',141.00,'2018-09-10'),('PB WHOLE SALE 190000',131.45,'2018-09-10'),('PETERSON 175021',38.00,'2018-09-10'),('5563',279.65,'2018-09-10'),('5528',555.66,'2018-09-10'),('PB WHOLESALE 190114',144.35,'2018-09-10'),('PB WHOLESALE 190066',44.00,'2018-09-10'),('FRESH MARKET',25.35,'2018-09-10'),('PETERSON 175044',52.50,'2018-09-10'),('FRESH MARKET',11.76,'2018-09-10'),('GARDEN DESING I11618',67.75,'2018-09-10'),('TRANS TO DW',-64.00,'2018-09-10'),('PB WHOLE SALE 190228',44.00,'2018-09-10'),('5579',907.66,'2018-09-17'),('RICHARDSON 86605',64.50,'2018-09-17'),('PETERSON 175086',25.00,'2018-09-17'),('TRI COUNTY 736142',91.30,'2018-09-17'),('PB WHOLE SALE 190420',47.00,'2018-09-17'),('SUPERNATURAL 16569',187.50,'2018-09-17'),('PB WHOLE SALE 1900478',22.50,'2018-09-17'),('FRESH MARKET',28.86,'2018-09-17'),('PETERSON 175110',55.25,'2018-09-17'),('PALM BEACH WHOLESALE',15.95,'2018-09-17'),('WHOLE FOODS FRESH',12.83,'2018-09-17'),('ROBERT TRUCK 5617',70.40,'2018-09-17'),('5636',757.85,'2018-09-24'),('credit',-12.50,'2018-09-24'),('PETERSON 175151',33.00,'2018-09-24'),('RICHARDSON 86634',95.00,'2018-09-24'),('N&N ORCH 216297',19.96,'2018-09-24'),('TRANS TO DW PLANT/FRESH',-38.00,'2018-09-24'),('PETERSON 172521',154.75,'2018-09-24'),('BUCKET TRUCK 5674',74.63,'2018-09-24'),('FRESH MARKET',63.07,'2018-09-24'),('FRESH MARKET',11.76,'2018-09-24'),('BLOOMING FREEDON 779',82.00,'2018-09-24'),('5663',31.00,'2018-09-24'),('5667',14.50,'2018-09-24'),('PB WHOLE SALE',138.45,'2018-10-01'),('KIRK & COMP 554051',57.25,'2018-10-01'),('KIRK & COMP 554051 DISPLAY',-26.25,'2018-10-01'),('RICHARDSON',67.50,'2018-10-01'),('PETERSON 171269',61.50,'2018-10-01'),('5688',848.37,'2018-10-01'),('5688 CREDIT',-30.00,'2018-10-01'),('TRI COUNTY 420147',50.80,'2018-10-01'),('GARDEN DESIGNS I1618',67.75,'2018-10-01'),('BUCKET TRUCK 5722',17.26,'2018-10-01'),('PB WHOLE SALE 191260',93.15,'2018-10-01'),('TRANS TO DW 5688',-60.00,'2018-10-01'),('TRANS TO DW 5688',-5.00,'2018-10-01'),('TRY COUNTY 037295',13.90,'2018-10-08'),('KIRK & COMPANY 554070',157.50,'2018-10-08'),('5735',739.32,'2018-10-08'),('cred',-30.00,'2018-10-08'),('FRSH MARKET',17.00,'2018-10-08'),('N&N ORCHIDS 217201',20.28,'2018-10-08'),('SUPER NATURAL 16690',248.50,'2018-10-08'),('PETERSON 171366',36.80,'2018-10-08'),('FRESH AMRKET ',67.00,'2018-10-08'),('5782',767.00,'2018-10-15'),('5798',402.00,'2018-10-15'),('CREDIT',-45.00,'2018-10-15'),('SUPERNATURAL 16741',164.00,'2018-10-15'),('GARDEN DESING I1984',65.85,'2018-10-15'),('PB WHOLE SALE 192170',68.45,'2018-10-15'),('FRESH MARKET',5.34,'2018-10-15'),('RICHARDSON 86773',101.00,'2018-10-15'),('PB WHOLE SALE 192064',80.60,'2018-10-15'),('5824',68.25,'2018-10-15'),('5824',-3.50,'2018-10-15'),('PETERSON 171403',20.50,'2018-10-15'),('PETERSON 171429',10.50,'2018-10-15'),('TRAS TO DW 3 CYM',-45.00,'2018-10-15'),('5835',985.60,'2018-10-22'),('richardson 86556',82.50,'2018-10-22'),('kirk & comp',19.50,'2018-10-22'),('peterson',15.00,'2018-10-22'),('PB WHOLE SALE 192739',129.00,'2018-10-22'),('PETERSON 171504',198.50,'2018-10-22'),('P B WHOLE SALE 192820',53.50,'2018-10-22'),('5883',25.00,'2018-10-22'),('KIRK & COMP 554123',42.00,'2018-10-29'),('GIVERNY GARDEN',5.29,'2018-10-29'),('GIVERNY GARDEN',27.60,'2018-10-29'),('5893',799.75,'2018-10-29'),('cred',15.00,'2018-10-29'),('RICHARSON 86588',38.00,'2018-10-29'),('PETERSON 171543',49.25,'2018-10-29'),('WHOLW FOODS FRSH',12.84,'2018-10-29'),('TRY COUNTY 191705',48.85,'2018-10-29'),('PETERSON 171562',27.50,'2018-10-29'),('PB WHOL. #193295',74.45,'2018-10-29'),('BLOOMING FREEDOM',172.00,'2018-10-29'),('FRESH MKT/WHOL FDS',46.00,'2018-10-29'),('KIRK AND CO.',113.00,'2018-11-05'),('TRI COUNTY FL #471108',40.85,'2018-11-05'),('RICHARDSON #86721',119.00,'2018-11-05'),('P B WHOLE SALE 193701',74.80,'2018-11-05'),('PB WHOLESALE #193630',84.25,'2018-11-05'),('PETERSON #171603',68.00,'2018-11-05'),('N & N ORCHIDS #218999',10.40,'2018-11-05'),('GARDEN DES. #12213',35.95,'2018-11-05'),('5962',376.75,'2018-11-05'),('5933',1037.36,'2018-11-05'),('SUPERNATURAL 16922',107.00,'2018-11-05'),('PETERSON 171623',56.80,'2018-11-05'),('TRICOUNTY #669503',34.75,'2018-11-12'),('RICHARDSON #86749',152.50,'2018-11-12'),('PETERSON #171656',18.00,'2018-11-12'),('FRESH MKT #0981G',27.80,'2018-11-12'),('GARDEN DES. #12292',154.50,'2018-11-12'),('PALM B WHOL. #194373',105.94,'2018-11-12'),('SUPER NATURAL 16987',304.50,'2018-11-12'),('P B WHOLE SALE 194481',83.95,'2018-11-12'),('PETERSON 175198',174.25,'2018-11-12'),('6032',55.76,'2018-11-12'),('5990',1141.00,'2018-11-12'),('KIRK& COM 855896',246.50,'2018-11-19'),('PETERSON 175225',252.50,'2018-11-19'),('P B WHOLE SALE 194841',47.20,'2018-11-19'),('6028',223.00,'2018-11-19'),('6052',2081.00,'2018-11-19'),('6079',161.00,'2018-11-19'),('PB WHOL #19404',58.50,'2018-11-19'),('FRESH MKT #01783G',54.48,'2018-11-19'),('PETERSON #175247',440.00,'2018-11-19'),('PALM BCH WHOL #195263',7.75,'2018-11-19'),('PALM BCH WHOL #195266',42.00,'2018-11-19'),('PALM BCH WHOL #19521',289.75,'2018-11-19'),('FRESH MKT #02326G',64.18,'2018-11-26'),('RICHARDSON #85613',416.50,'2018-11-26'),('TRI COUNTY #',17.90,'2018-11-26'),('PETERSON #171691',15.75,'2018-11-26'),('LONNIE MILLS 5689',61.00,'2018-11-26'),('HOME DEPOT #',12.79,'2018-11-26'),('GARDEN DESIGNS #12411',18.55,'2018-11-26'),('PALM BCH WHOL #196006',294.45,'2018-11-26'),('PALM BCH WHOL. #196096',161.28,'2018-11-26'),('6162',60.00,'2018-11-26'),('6180',687.00,'2018-11-26'),('SUPERNATURAL 17111',314.00,'2018-12-03'),('PETERSON 174118',142.00,'2018-12-03'),('PETERSON #174139',48.00,'2018-12-03'),('KIRK #554155',159.50,'2018-12-03'),('PALM BCH WHOL. #196334',55.90,'2018-12-03'),('N&N ORCHIDS 220646',19.76,'2018-12-03'),('TRI COUNTY #694118',25.90,'2018-12-03'),('GARDEN DESIGNS#I2499',43.80,'2018-12-03'),('SUPERNATURALS #17169',262.00,'2018-12-03'),('LONNIE MILLS 5649',111.25,'2018-12-03'),('PALM BCH WHOL #196774',428.70,'2018-12-03'),('6198',590.00,'2018-12-03'),('TRI COUNTY #694135',45.90,'2018-12-10'),('KIRK #554173',150.00,'2018-12-10'),('6246',700.00,'2018-12-10'),('RICHARSON 85776',268.50,'2018-12-10'),('PB WHOLE SALE 197014',69.90,'2018-12-10'),('TRANS TO DW AMARYLLIS',-36.00,'2018-12-10'),('PETERSON 174219',91.50,'2018-12-10'),('GARDEN DESIGNS #I 2579',30.70,'2018-12-10'),('PALM BCH WHOL. #197171',164.70,'2018-12-10'),('PETERSON #174241',196.00,'2018-12-10'),('SUPER NATURAL 17228',269.00,'2018-12-10'),('6282',295.35,'2018-12-10'),('PETERSON 172837',77.00,'2018-12-27'),('RICHARDSON 85809',160.00,'2018-12-27'),('PB WHOLE SALE 197437',52.50,'2018-12-27'),('LONNIE MILLS 5704',207.50,'2018-12-27'),('SUPER NATURAL 17291',204.00,'2018-12-27'),('PALM BCH WHOL #197924',744.06,'2018-12-27'),('PALM BCH WHOL# 197915',71.60,'2018-12-27'),('PETERSON #172859',92.00,'2018-12-27'),('LONNIE MILLS #5730',92.00,'2018-12-27'),('PETERSON #172868',295.75,'2018-12-27'),('pALM BCH WHOL #19853',148.95,'2018-12-27'),('K & M NURS #490645',1395.50,'2018-12-27'),('6308',719.60,'2018-12-27'),('6339',274.50,'2018-12-27'),('6351',286.16,'2018-12-27'),('6353',514.00,'2018-12-27'),('6364',492.65,'2018-12-27'),('GARDEN DES.#I2667',521.15,'2018-12-24'),('KIRK AND CO #554206',570.00,'2018-12-24'),('N & N ORCHID #221389',37.00,'2018-12-24'),('N & N ORCHID #221475',59.60,'2018-12-24'),('N & N ORCHID #221452',183.56,'2018-12-24'),('PALM BCH WHOL #197796',62.10,'2018-12-24'),('6392',568.34,'2018-12-24'),('PALM BCH WHOL #19894',52.50,'2018-12-24'),('PALM BCH WHOL #198597',44.95,'2018-12-24'),('PETERSON #172905',157.50,'2018-12-24');

-- Populating Invoice table
SET @row_number:=100;
Insert into `invoices`(store_week_id,invoice_number,invoice_name,invoice_date,created_at,updated_at,total)
SELECT 
    st.id, concat(date_format(it.`invoice_date`,'%Y%m%d'),@row_number:=@row_number+1) as `invoice_number`, 
     it.`invoice_name`, it.`invoice_date`,now(),now(),it.`invoice_amt`
FROM
    invoice_temp it
        INNER JOIN
    dates_dim dd ON it.invoice_date = dd.`date`
        INNER JOIN
    weeks w ON dd.week_starting_monday = w.`number`
        AND dd.week_year = w.`year`
        inner join store_week st on w.id=st.week_id and store_id=3
;
 DROP TABLE IF EXISTS `invoice_temp`;
EOT;
        DB::unprepared($sql);
    }
}