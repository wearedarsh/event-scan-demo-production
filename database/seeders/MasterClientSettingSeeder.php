<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class MasterClientSettingSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            \Database\Seeders\ClientSetting\ClientSettingCategoriesSeeder::class,
            \Database\Seeders\ClientSetting\ClientSettingsEmailSeeder::class,
            \Database\Seeders\ClientSetting\ClientSettingsBookingSeeder::class,
            \Database\Seeders\ClientSetting\ClientSettingsGeneralSeeder::class,
            \Database\Seeders\ClientSetting\ClientSettingsPaymentSeeder::class,
            \Database\Seeders\ClientSetting\ClientSettingsCheckInAppSeeder::class,
        ]);
    }
}
