<?php

namespace Database\Seeders;

use App\Models\StaffCategory;
use Illuminate\Database\Seeder;

class StaffCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        StaffCategory::create([
            'id' => 1,
            'title' => "Waitresses/Bucks",
            'slug' => 'bucks-party',
            'gender' => 'female',
        ]);
        
        StaffCategory::create([
            'id' => 2,
            'title' => "Hens Staff / Male Waiters",
            'slug' => 'hens-party',
            'gender' => 'male',
        ]);
        
        StaffCategory::create([
            'id' => 3,
            'title' => "DJS",
            'slug' => 'djs',
        ]);
        StaffCategory::create([
            'id' => 4,
            'title' => "Event Staff",
            'slug' => 'private-party',
        ]);
        StaffCategory::create([
            'id' => 5,
            'title' => "Entertainers",
            'slug' => 'entertainers',
        ]);
        StaffCategory::create([
            'id' => 6,
            'title' => "Promotional Staff",
            'slug' => 'promo-party',
        ]);
        StaffCategory::create([
            'id' => 7,
            'title' => "Photographers",
            'slug' => 'photograpgher',
        ]);
        StaffCategory::create([
            'id' => 8,
            'title' => "ShowStaff X",
            'slug' => 'showstaffx',
            'gender' => 'female',
        ]);

        // Waitresses/Bucks Child Categories
        StaffCategory::create([
            'title' => "Party Host",
            'slug' => 'party-host',
            'category_id' => 1,
            'min_rate' => 50
        ]);
        StaffCategory::create([
            'title' => "Bikini waitress",
            'slug' => 'bikini-waitress',
            'category_id' => 1,
            'min_rate' => 60
        ]);
        StaffCategory::create([
            'title' => "Lingerie waitress",
            'slug' => 'lingerie-waitress',
            'category_id' => 1,
            'min_rate' => 90
        ]);
        StaffCategory::create([
            'title' => "Topless waitress",
            'slug' => 'topless-waitress',
            'category_id' => 1,
            'min_rate' => 100
        ]);
        StaffCategory::create([
            'title' => "Waitress Poker Dealer",
            'slug' => 'poker-dealer',
            'category_id' => 1,
            'min_rate' => 100
        ]);
        StaffCategory::create([
            'title' => "Model",
            'slug' => 'bucks-party-model',
            'category_id' => 1,
            'min_rate' => 50
        ]);
        StaffCategory::create([
            'title' => "After party bikini cleaner",
            'slug' => 'after-party-bikini-cleaner',
            'category_id' => 1,
            'min_rate' => 60
        ]);

        // Hens Staff / Male Waiters Child Categories
        StaffCategory::create([
            'title' => "Hens Party Waiter",
            'slug' => 'topless-waiter',
            'category_id' => 2,
            'min_rate' => 90
        ]);
        StaffCategory::create([
            'title' => "Hens Party Bartender",
            'slug' => 'hens-night-bartender',
            'category_id' => 2,
            'min_rate' => 90
        ]);
        StaffCategory::create([
            'title' => "Bartender",
            'slug' => 'hens-night-topless-bartender',
            'category_id' => 2,
        ]);
        
        
        // DJS Child Categories
        StaffCategory::create([
            'title' => "DJ",
            'slug' => 'dj',
            'category_id' => 3,
        ]);
        
        // Event Staff Child Categories
        StaffCategory::create([
            'title' => "Kitchen Hand",
            'slug' => 'kitchen-hand',
            'category_id' => 4,
        ]);
        StaffCategory::create([
            'title' => "Waiter",
            'slug' => 'wait',
            'category_id' => 4,
            'min_rate' => 25
        ]);
        StaffCategory::create([
            'title' => "Bartender",
            'slug' => 'bar',
            'category_id' => 4,
            'min_rate' => 30
        ]);
        StaffCategory::create([
            'title' => "Cocktail Bartender",
            'slug' => 'cocktail-bartender',
            'category_id' => 4,
        ]);
        StaffCategory::create([
            'title' => "After-party cleaner",
            'slug' => 'cleaner',
            'category_id' => 4,
        ]);

        // Entertainers Child Categories
        StaffCategory::create([
            'title' => "Face Painter",
            'slug' => 'face-painter',
            'category_id' => 5,
        ]);
        StaffCategory::create([
            'title' => "Fire performers",
            'slug' => 'fire-performer',
            'category_id' => 5,
            'min_rate' => 100
        ]);
        StaffCategory::create([
            'title' => "Burlesque Dancers",
            'slug' => 'burlesque-dancers',
            'category_id' => 5,
            'min_rate' => 100
        ]);


        // Promotional Staff Child Categories
        StaffCategory::create([
            'title' => "Promotional Staff",
            'slug' => 'promo',
            'category_id' => 6,
            'min_rate' => 30
        ]);
        StaffCategory::create([
            'title' => "Model",
            'slug' => 'promo-party-model',
            'category_id' => 6,
        ]);
        StaffCategory::create([
            'title' => "Atmosphere Model",
            'slug' => 'atmosphere-model',
            'category_id' => 6,
            'min_rate' => 30
        ]);


        // Photographers Child Categories
        StaffCategory::create([
            'title' => "Event Photographer",
            'slug' => 'event-photographer',
            'category_id' => 7,
        ]);
        StaffCategory::create([
            'title' => "Party Photographer",
            'slug' => 'party-photographer',
            'category_id' => 7,
        ]);
        StaffCategory::create([
            'title' => "Wedding Photographer",
            'slug' => 'wedding-photographer',
            'category_id' => 7,
        ]);
        StaffCategory::create([
            'title' => "Model Photographer",
            'slug' => 'model-photographer',
            'category_id' => 7,
        ]);


        // PartiStaff X Child Categories
        StaffCategory::create([
            'title' => "Topless Poker Dealer",
            'slug' => 'topless-poker-dealer',
            'category_id' => 8,
            // 'min_rate' => 0
        ]);
        StaffCategory::create([
            'title' => "Topless Waitress",
            'slug' => 'topless-waitress-showstaff-x',
            'category_id' => 8,
            'min_rate' => 120 
        ]);
        StaffCategory::create([
            'title' => "After party topless cleaner",
            'slug' => 'after-party-topless-cleaner',
            'category_id' => 8,
            'min_rate' => 120
        ]);

    }
}
