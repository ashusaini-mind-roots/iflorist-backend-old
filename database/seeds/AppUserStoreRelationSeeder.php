<?php

use Illuminate\Database\Seeder;
use App\Models\AppUser;

class AppUserStoreRelationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AppUser::create(['user_id' => '4','store_id' => '2','activate'=>'1']);
        AppUser::create(['user_id' => '6','store_id' => '1','activate'=>'1']);
	}
}
