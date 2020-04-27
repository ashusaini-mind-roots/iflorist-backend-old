<?php
use Illuminate\Database\Seeder;
use App\Models\Status;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Status::create(['name' => 'Director','code' => 'director']);
        Status::create(['name' => 'Sub Contractor','code' => 'subcontractor']);
    }
}
