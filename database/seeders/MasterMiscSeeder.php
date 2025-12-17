<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class MasterMiscSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            \Database\Seeders\Misc\AttendeeTypesSeeder::class,
            \Database\Seeders\Misc\CountriesSeeder::class,
            \Database\Seeders\Misc\TestimonialSeeder::class,
        ]);
    }
}
