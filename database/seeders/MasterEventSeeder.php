<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class MasterEventSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            \Database\Seeders\Event\EventSeeder::class,
            \Database\Seeders\Event\EventOptInCheckSeeder::class,
            \Database\Seeders\Event\EventContentSeeder::class,
            \Database\Seeders\Event\EventHtmlEmailContentSeeder::class,
            \Database\Seeders\Event\EventPaymentMethodSeeder::class,
            \Database\Seeders\Event\EventSessionTypeSeeder::class,
        ]);
    }
}
