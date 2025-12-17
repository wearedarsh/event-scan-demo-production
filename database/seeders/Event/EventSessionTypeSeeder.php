<?php

namespace Database\Seeders\Event;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EventSessionType;

class EventSessionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $event_session_types = [
            ['friendly_name' => 'Workshop', 'active' => true],
            ['friendly_name' => 'Lecture', 'active' => true],
        ];

        EventSessionType::insert($event_session_types);
    }
}
