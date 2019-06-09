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
        Store::create(['store_name' => 'Flowermart']);
        Store::create(['store_name' => 'Flowers of Fort Lauderdale']);
        Store::create(['store_name' => 'Driftwood']);
        Store::create(['store_name' => 'Miami Gardens Florist']);
        Store::create(['store_name' => 'Design Center']);
    }
}
