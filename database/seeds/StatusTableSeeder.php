<?php
use Illuminate\Database\Seeder;
use App\Models\Statu;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Statu::create(['name' => 'Director','code' => 'director']);
        Statu::create(['name' => 'Sub Contractor','code' => 'subcontractor']);
    }
}
