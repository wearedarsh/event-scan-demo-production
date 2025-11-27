<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Event;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $events = [
            [
                'id' => 1,
                'title' => 'Medical Imaging Skills Workshop',
                'location' => 'London, UK',
                'date_start' => '2026-06-12',
                'date_end' => '2026-06-12',
                'event_attendee_limit' => 80,
                'vat_percentage' => 20.00,
                'full' => 0,
                'active' => 1,
                'template' => 1,
                'provisional' => 0,
                'show_email_marketing_opt_in' => true,
                'email_opt_in_description' => 'By registering you agree to receive all communications related to this event.',
                'email_list_id' => 000,
                'auto_email_opt_in' => true,
            ],

            [
                'id' => 2,
                'title' => 'Acute Care Masterclass',
                'location' => 'Paris, France',
                'date_start' => '2026-11-05',
                'date_end' => '2026-11-06',
                'event_attendee_limit' => 120,
                'vat_percentage' => 20.00,
                'full' => 0,
                'active' => 1,
                'template' => 1,
                'provisional' => 1,
                'show_email_marketing_opt_in' => true,
                'email_opt_in_description' => 'You will receive updates when registration opens.',
                'email_list_id' => 000,
                'auto_email_opt_in' => true,
            ],
            [
                'id' => 3,
                'title' => 'Clinical Procedures Intensive Course',
                'location' => 'Milan, Italy',
                'date_start' => '2026-04-03',
                'date_end' => '2026-04-04',
                'event_attendee_limit' => 60,
                'vat_percentage' => 20.00,
                'full' => 1,
                'active' => 1,
                'template' => 1,
                'provisional' => 0,
                'show_email_marketing_opt_in' => true,
                'email_opt_in_description' => 'By registering you agree to receive all communications related to this event.',
                'email_list_id' => 000,
                'auto_email_opt_in' => true,
            ],
        ];

        Event::insert($events);
    }
}
