<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\TicketGroup;

class TicketGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ticket_groups = [
            [
                'id' => 1, 
                'event_id' => 1, 
                'name' => 'Registration tickets',
                'active' => 1,
                'display_order' => 1,
                'description' => 'Please select your registration ticket',
                'multiple_select' => 0,
                'required' => 1,
            ],
            [
                'id' => 2, 
                'event_id' => 1, 
                'name' => 'Social tickets',
                'active' => 1,
                'display_order' => 2,
                'description' => 'Please select which social tickets you would like',
                'multiple_select' => 1,
                'required' => 0,
            ],
        ];

        TicketGroup::insert($ticket_groups);
    }
}
