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
        $this->call(CompanyTableSeeder::class);
        $this->call(RolesTableSeeder::class);
		$this->call(UserRoleTableSeeder::class);
        $this->call(StoresTableSeeder::class);
        $this->call(DatesDimTableSeeder::class);
        $this->call(WeeksTableSeeder::class);
        $this->call(StoreWeekTableSeeder::class);
        $this->call(DailyRevenuesTableSeeder::class);
        $this->call(WeeklyProjectionPercentRevenueTableSeeder::class);
        $this->call(WeeklyProjectionPercentCostsTableSeeder::class);
//        $this->call(InvoiceTableSeeder::class);
        $this->call(TargetPercentageTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(WorkMansCombTableSeeder::class);
        $this->call(TaxPercentCalculatorsTableSeeder::class);
        $this->call(ModulesTableSeeder::class);
        $this->call(PlansTableSeeder::class);
        $this->call(PlanModuleTableSeeder::class);
        $this->call(StatusTableSeeder::class);
        $this->call(CompanyPlanTableSeeder::class);
		$this->call(EmployeeTableSeeder::class);
        $this->command->info('****Seeds were properly seeded, these guys are the best !!!****');
    }
}
