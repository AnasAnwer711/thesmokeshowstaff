<?php

namespace Database\Seeders;

use App\Models\CancellationPolicy;
use Illuminate\Database\Seeder;

class CancellationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CancellationPolicy::create([
            'user_type' => "staff",
            'duration' => 20160,
            'charges' => 5,
            'rule_type' => "cancel",
        ]);
        CancellationPolicy::create([
            'user_type' => "staff",
            'duration' => 4320,
            'charges' => 80,
            'rule_type' => "cancel",
        ]);
        CancellationPolicy::create([
            'user_type' => "staff",
            'duration' => 0,
            'charges' => 100,
            'rule_type' => "no-show",
        ]);
    }
}
