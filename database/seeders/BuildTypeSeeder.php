<?php

namespace Database\Seeders;

use App\Models\BuildType;
use Illuminate\Database\Seeder;

class BuildTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BuildType::create([
            'name' => "N/A",
            'description' => "Not available",
        ]);
        BuildType::create([
            'name' => "Slim",
            'description' => "Slim and smart build",
        ]);
        BuildType::create([
            'name' => "Athletic",
            'description' => "Flexible build",
        ]);
        BuildType::create([
            'name' => "Average",
            'description' => "Perfect build",
        ]);
        BuildType::create([
            'name' => "A bit of overweight",
            'description' => null,
        ]);
        BuildType::create([
            'name' => "Overweight",
            'description' => "Complete overweight",
        ]);
    }
}
