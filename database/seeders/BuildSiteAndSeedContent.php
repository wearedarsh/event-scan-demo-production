<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class BuildSiteAndSeedContent extends Seeder
{
    public function run(): void
    {
        $this->call([
            \Database\Seeders\MasterRegistrationFormSeeder::class,
            \Database\Seeders\MasterEventSeeder::class,
            \Database\Seeders\MasterClientSettingSeeder::class,
            \Database\Seeders\MasterMiscSeeder::class,
            \Database\Seeders\MasterTicketSeeder::class,
            \Database\Seeders\MasterFeedbackFormSeeder::class,
        ]);
    }
}
