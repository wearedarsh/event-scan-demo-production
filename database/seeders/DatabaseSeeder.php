<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Seeders\EventSeeder;
use Database\Seeders\TicketGroupSeeder;
use Database\Seeders\TicketSeeder;
use Database\Seeders\EventContentSeeder;
use Database\Seeders\EventOptInCheckSeeder;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // DB::table('registration_opt_in_responses')->truncate();
        // DB::table('event_opt_in_checks')->truncate();
        // DB::table('tickets')->truncate();
        // DB::table('ticket_groups')->truncate();
        // DB::table('event_contents')->truncate();
        // DB::table('events')->truncate();

        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // $this->call([
        //     EventSeeder::class,
        //     TicketGroupSeeder::class,
        //     TicketSeeder::class,
        //     EventContentSeeder::class,
        //     EventOptInCheckSeeder::class,
        // ]);
    }
}
