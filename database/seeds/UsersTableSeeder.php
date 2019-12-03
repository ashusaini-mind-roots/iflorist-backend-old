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
            'role_id' => 1,
            'activated_account' => '1'
        ]);

        User::create([
            'name' => 'Manager',
            'email' => 'manager@test.com',
            'password' => Hash::make('test'),
            'role_id' => 2,
            'activated_account' => '1'
        ]);

        User::create([
            'name' => 'User',
            'email' => 'User@test.com',
            'password' => Hash::make('test'),
            'role_id' => 3,
            'activated_account' => '1'
        ]);
    }
}
