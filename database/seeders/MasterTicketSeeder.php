<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class MasterTicketSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            \Database\Seeders\Ticket\TicketGroupSeeder::class,
            \Database\Seeders\Ticket\TicketSeeder::class,
        ]);
    }
}
