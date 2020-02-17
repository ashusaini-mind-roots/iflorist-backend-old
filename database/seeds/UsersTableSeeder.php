<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
       // User::truncate();

//        User::create([
//            'name' => 'Company Admin',
//            'email' => 'companyadmin@test.com',
//            'password' => Hash::make('test'),
//            'activated_account' => '1'
//        ]);
//
//        User::create([
//            'name' => 'Store Manager',
//            'email' => 'storemanager@test.com',
//            'password' => Hash::make('test'),
//            'activated_account' => '1'
//        ]);

        User::create([
            'name' => 'Root',
            'email' => 'root@test.com',
            'password' => Hash::make('test'),
            'activated_account' => '1'
        ]);

        User::create([
            'name' => 'App',
            'email' => 'app@test.com',
            'password' => Hash::make('test'),
            'activated_account' => '1'
        ]);


//		User::create([
//            'name' => 'Employee',
//            'email' => 'employee1@test.com',
//            'password' => Hash::make('test'),
//            'activated_account' => '1'
//        ]);
//
//        User::create([
//            'name' => 'App1',
//            'email' => 'app1@test.com',
//            'password' => Hash::make('test'),
//            'activated_account' => '1'
//        ]);
    }
}
