<?php

namespace Database\Seeders;

use App\Models\TravelAllowance;
use Illuminate\Database\Seeder;

class TravelAllowanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TravelAllowance::create([
            'title' => "UBER - One Way",
            'rate' => 40.00,
        ]);
        TravelAllowance::create([
            'title' => "UBER - Both Ways",
            'rate' => 70.00,
        ]);
        TravelAllowance::create([
            'title' => "50$",
            'rate' => 50.00,
        ]);
        TravelAllowance::create([
            'title' => "100$",
            'rate' => 100.00,
        ]);
    }
}
