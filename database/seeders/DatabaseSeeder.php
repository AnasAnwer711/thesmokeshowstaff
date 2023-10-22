<?php

namespace Database\Seeders;

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
        $this->call(NationalitySeeder::class);
        $this->call(BuildTypeSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(StaffCategorySeeder::class);
        $this->call(TravelAllowanceSeeder::class);
        $this->call(SubscriptionPlanSeeder::class);
        $this->call(StateSeeder::class);
        $this->call(CancellationSeeder::class);
        $this->call(DisputeTitleSeeder::class);
        $this->call(HelpfulKeySeeder::class);
        $this->call(LanguageSeeder::class);
        $this->call(CurrencySeeder::class);
        
        // \App\Models\User::factory(10)->create();
    }
}
