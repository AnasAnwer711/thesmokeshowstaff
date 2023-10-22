<?php

namespace Database\Seeders;

use App\Models\HelpfulKey;
use Illuminate\Database\Seeder;

class HelpfulKeySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['title'=>'PARTY HOST','icon'=>'/images/helpful-icons/host.png', 'description' => 'PARTY HOST'],
            ['title'=>'BIKINI / LINGERIE','icon'=>'/images/helpful-icons/bikini.png', 'description' => 'BIKINI / LINGERIE'],
            ['title'=>'PARTISTAFF X','icon'=>'/images/helpful-icons/r18.png', 'description' => 'PARTISTAFF X'],
            ['title'=>'CARD DEALER','icon'=>'/images/helpful-icons/card_dealer.png', 'description' => 'CARD DEALER'],
            ['title'=>'CLEANER','icon'=>'/images/helpful-icons/cleaner.png', 'description' => 'CLEANER'],
            ['title'=>'WAITRESS / WAITER','icon'=>'/images/helpful-icons/waiter.png', 'description' => 'WAITRESS / WAITER'],
            ['title'=>'DJ','icon'=>'/images/helpful-icons/dj.png', 'description' => 'DJ'],
            ['title'=>'FACE PAINTER','icon'=>'/images/helpful-icons/face_painter.png', 'description' => 'FACE PAINTER'],
            ['title'=>'FIRE PERFORMERS','icon'=>'/images/helpful-icons/fire_performer.png', 'description' => 'FIRE PERFORMERS'],
            ['title'=>'BURLESQUE DANCERS','icon'=>'/images/helpful-icons/dancer.png', 'description' => 'BURLESQUE DANCERS'],
            ['title'=>'KITCHEN HAND','icon'=>'/images/helpful-icons/kitchen.png', 'description' => 'KITCHEN HAND'],
            ['title'=>'MIXOLOGIST','icon'=>'/images/helpful-icons/mixologist.png', 'description' => 'MIXOLOGIST'],
            ['title'=>'PROMOTIONAL STAFF','icon'=>'/images/helpful-icons/promotional_staff.png', 'description' => 'PROMOTIONAL STAFF'],
            ['title'=>'PHOTOGRAPHER','icon'=>'/images/helpful-icons/photographer.png', 'description' => 'PHOTOGRAPHER'],
        ];

        HelpfulKey::insert($data);
    }
}
