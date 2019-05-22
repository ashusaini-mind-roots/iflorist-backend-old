<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(StoresTableSeeder::class);
        $this->call(DatesDimTableSeeder::class);
        $this->call(WeeksTableSeeder::class);
        $this->call(StoreWeekTableSeeder::class);
        $this->call(DailyRevenuesTableSeeder::class);
        $this->call(WeeklyProjectionPercentRevenueTableSeeder::class);
        $this->call(WeeklyProjectionPercentCostsTableSeeder::class);
        $this->call(InvoiceTableSeeder::class);
        $this->command->info('****Vaya salvaje corrieron los migrations sin bateo :) !!!****');
    }
}
