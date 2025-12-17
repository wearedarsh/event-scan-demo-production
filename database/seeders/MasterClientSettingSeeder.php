<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;

class MasterClientSettingSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            \Database\Seeders\ClientSetting\ClientSettingCategoriesSeeder::class,
            \Database\Seeders\ClientSetting\ClientSettingsSeeder::class,
        ]);
    }
}
