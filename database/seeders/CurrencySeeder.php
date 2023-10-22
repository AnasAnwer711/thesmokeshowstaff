<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [

            ['name'=>'usd','symbol'=>'$', 'description' => 'United States Dollar'],
            ['name'=>'cad','symbol'=>'$', 'description' => 'Canadian Dollar'],
            ['name'=>'eur','symbol'=>'€', 'description' => 'Euro'],
            ['name'=>'gbp','symbol'=>'£', 'description' => 'British Pound'],
        ];

        Currency::insert($data);
    }

}
