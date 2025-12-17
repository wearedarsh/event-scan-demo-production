<?php

namespace Database\Seeders\Ticket;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ticket;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tickets = [
            [
                'event_id' => 1, 
                'name' => 'Attendee', 
                'price' => 700.00,
                'requires_document_upload' => 0,
                'max_volume' => 1,
                'ticket_group_id' => 1,
                'requires_document_copy' => null,
                'active' => 1,
                'display_front_end' => 1,
            ],
            [
                'event_id' => 1, 
                'name' => 'Farewell Dinner', 
                'price' => 300.00,
                'requires_document_upload' => 0,
                'max_volume' => 3,
                'ticket_group_id' => 2,
                'requires_document_copy' => null,
                'active' => 1,
                'display_front_end' => 0,
            ],
            [
                'event_id' => 1, 
                'name' => 'Reduced ticket', 
                'price' => 600.00,
                'requires_document_upload' => 1,
                'max_volume' => 1,
                'ticket_group_id' => 1,
                'requires_document_copy' => 'Please upload your identification.',
                'active' => 1,
                'display_front_end' => 0,
            ]
        ];

        Ticket::insert($tickets);
    }
}
