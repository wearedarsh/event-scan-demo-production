<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ClientSettingsCategory;

class ClientSettingsCategoriesSeeder extends Seeder
{
    public function run(): void
    {
        ClientSettingsCategory::insert([
            [
                'id' => 1,
                'key_name' => 'email',
                'label' => 'Email',
                'display_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'key_name' => 'api',
                'label' => 'API',
                'display_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'key_name' => 'booking',
                'label' => 'Booking website',
                'display_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'key_name' => 'admin',
                'label' => 'Admin',
                'display_order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 5,
                'key_name' => 'check_in_app',
                'label' => 'Check-in app',
                'display_order' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
