<?php

namespace Database\Seeders;

use App\Models\DisputeTitle;
use Illuminate\Database\Seeder;

class DisputeTitleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['title'=>'There was a problem with booking','user_type'=>'staff'],
            ['title'=>'Party location issue','user_type'=>'staff'],
            ['title'=>'Payment or refund enquiry','user_type'=>'staff'],
            ['title'=>'I have a different issue','user_type'=>'staff'],
            
            ['title'=>'There was a problem with booking','user_type'=>'host'],
            ['title'=>'I had an issue with staff behaviour','user_type'=>'host'],
            ['title'=>'Payment or refund enquiry','user_type'=>'host'],
            ['title'=>'I have a different issue','user_type'=>'host'],
        ];

        DisputeTitle::insert($data);
    }
}
