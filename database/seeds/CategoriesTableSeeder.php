<?php

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create(['name' => 'Driver','code' => 'driver','omit_col' => '1']);
        Category::create(['name' => 'Operation','code' => 'operation','omit_col' => '0']);
        Category::create(['name' => 'Helper','code' => 'helper','omit_col' => '0']);
        Category::create(['name' => 'Designer','code' => 'designer','omit_col' => '0']);
    }
}
