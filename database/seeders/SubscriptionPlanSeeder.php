<?php

namespace Database\Seeders;

use App\Models\SubscriptionPlan;
use Illuminate\Database\Seeder;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        SubscriptionPlan::create([
            'title' => "Parti Savvy",
            'unit_price' => 27.50,
            'amount' => 82.50,
            'limit' => 3,
            'additional_note' => "Save 21%",
            'duration_period' => "month",
            'duration_number' => 6,
            'status' => "active",
        ]);

        SubscriptionPlan::create([
            'title' => "Parti Starter",
            'unit_price' => 25,
            'amount' => 200,
            'limit' => 8,
            'additional_note' => "Save 29%",
            'duration_period' => "month",
            'duration_number' => 6,
            'status' => "active",
        ]);

        SubscriptionPlan::create([
            'title' => "Parti Legend",
            'unit_price' => 22.50,
            'amount' => 675,
            'limit' => 30,
            'additional_note' => "Save 36%",
            'duration_period' => "year",
            'duration_number' => 1,
            'status' => "active",
        ]);
    }
}
