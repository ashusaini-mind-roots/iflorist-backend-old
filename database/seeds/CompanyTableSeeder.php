<?php

use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::create([
            'name' => 'Company Red',
            'ba_street' => 'ba_street ',
            'ba_city' => 'ba_city ',
            'ba_state' => 'ba_state',
            'ba_zip_code' => '123',
            'card_holder_name' => 'card_holder_name',
            'canceled_account' => '0',
            'user_id' => '1',
        ]);
    }
}
