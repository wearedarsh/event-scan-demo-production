<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class MasterClientSettingSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            \Database\Seeders\ClientSetting\ClientSettingCategoriesSeeder::class,
            \Database\Seeders\ClientSetting\ClientSettingEmailSeeder::class,
            \Database\Seeders\ClientSetting\ClientSettingBookingSeeder::class,
            \Database\Seeders\ClientSetting\ClientSettingGeneralSeeder::class,
            \Database\Seeders\ClientSetting\ClientSettingPaymentSeeder::class,
            \Database\Seeders\ClientSetting\ClientSettingCheckInAppSeeder::class,
            \Database\Seeders\ClientSetting\ClientSettingLegalSeeder::class,
            \Database\Seeders\ClientSetting\ClientSettingTicketSeeder::class,
        ]);
    }
}
