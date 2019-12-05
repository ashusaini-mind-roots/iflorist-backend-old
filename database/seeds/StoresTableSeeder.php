<?php

use Illuminate\Database\Seeder;
use App\Models\Store;

class StoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Store::truncate();
        Store::create(['store_name' => 'Flowermart','company_id' => '1','contact_phone'=>'54789856','contact_email'=>'flowermart@gmail.com','address'=>'address','zip_code'=>'1234','image'=>'default']);
        Store::create(['store_name' => 'Flowers of Fort Lauderdale','company_id' => '1','contact_phone'=>'54789856','contact_email'=>'flowersLauderdale@gmail.com','address'=>'address','zip_code'=>'1234','image'=>'default']);
        Store::create(['store_name' => 'Driftwood','company_id' => '1','contact_phone'=>'54789856','contact_email'=>'Driftwood@gmail.com','address'=>'address','zip_code'=>'1234','image'=>'default']);
        Store::create(['store_name' => 'Miami Gardens Florist','company_id' => '1','contact_phone'=>'54789856','contact_email'=>'miami@gmail.com','address'=>'address','zip_code'=>'1234','image'=>'default']);
        Store::create(['store_name' => 'Design Center','company_id' => '1','contact_phone'=>'54789856','contact_email'=>'design@gmail.com','address'=>'address','zip_code'=>'1234','image'=>'default']);
    }
}
