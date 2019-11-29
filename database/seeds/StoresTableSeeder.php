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
        Store::create(['store_name' => 'Flowermart','company_id' => '1']);
        Store::create(['store_name' => 'Flowers of Fort Lauderdale','company_id' => '1']);
        Store::create(['store_name' => 'Driftwood','company_id' => '1']);
        Store::create(['store_name' => 'Miami Gardens Florist','company_id' => '1']);
        Store::create(['store_name' => 'Design Center','company_id' => '1']);
    }
}
