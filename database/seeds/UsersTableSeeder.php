<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
       // User::truncate();

        User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('test'),
            'activated_account' => '1'
        ]);

        User::create([
            'name' => 'Admin Store',
            'email' => 'adminstore@test.com',
            'password' => Hash::make('test'),
            'activated_account' => '1'
        ]);

        User::create([
            'name' => 'User',
            'email' => 'User@test.com',
            'password' => Hash::make('test'),
            'activated_account' => '1'
        ]);

        User::create([
            'name' => 'App',
            'email' => 'app@test.com',
            'password' => Hash::make('test'),
            'activated_account' => '1'
        ]);
    }
}
