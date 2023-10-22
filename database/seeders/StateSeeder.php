<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        State::create([
            'name' => "Alberta",
            'abbreviation' => 'AB',
        ]);
        State::create([
            'name' => "British Columbia",
            'abbreviation' => 'BC',
        ]);
        State::create([
            'name' => "Manitoba",
            'abbreviation' => 'MB',
        ]);
        State::create([
            'name' => "New Brunswick",
            'abbreviation' => 'NB',
        ]);
        State::create([
            'name' => "Newfoundland and Labrador",
            'abbreviation' => 'NL',
        ]);
        State::create([
            'name' => "Northwest Territories",
            'abbreviation' => 'NT',
        ]);
        State::create([
            'name' => "Nova Scotia",
            'abbreviation' => 'NS',
        ]);
        State::create([
            'name' => "Nunavut",
            'abbreviation' => 'NU',
        ]);
        State::create([
            'name' => "Ontario",
            'abbreviation' => 'ON',
        ]);
        State::create([
            'name' => "Prince Edward Island",
            'abbreviation' => 'PE',
        ]);
        State::create([
            'name' => "Quebec",
            'abbreviation' => 'QC',
        ]);
        State::create([
            'name' => "Saskatchewan",
            'abbreviation' => 'SK',
        ]);
        State::create([
            'name' => "Yukon Territory",
            'abbreviation' => 'YT',
        ]);
    }
}
