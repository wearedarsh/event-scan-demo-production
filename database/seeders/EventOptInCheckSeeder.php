<?php

namespace Database\Seeders;

use App\Models\EventOptInCheck;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventOptInCheckSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        //DB::table('event_opt_in_checks')->truncate();
        $event_opt_in_checks = [
            [
                'event_id' => 1, 
                'name' => 'photography',
                'friendly_name' => 'Photography consent',
                'description' => 'I give consent for any photographs taken during the event to be used on websites and social media platforms',
                'sort_order' => 2
            ],
            [
                'event_id' => 1, 
                'name' => 'third_party', 
                'friendly_name' => 'Share with third parties consent',
                'description' => 'I give consent for my details to be shared with sponsors/exhibitors of the meeting',
                'sort_order' => 1
            ],
        ];

        EventOptInCheck::insert($event_opt_in_checks);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
