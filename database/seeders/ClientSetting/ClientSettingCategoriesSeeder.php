<?php

namespace Database\Seeders\ClientSetting;

use Illuminate\Database\Seeder;
use App\Models\ClientSettingCategory;

class ClientSettingCategoriesSeeder extends Seeder
{
    public function run(): void
    {
        ClientSettingCategory::insert([
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
            [
                'id' => 6,
                'key_name' => 'general',
                'label' => 'General',
                'display_order' => 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 7,
                'key_name' => 'payment',
                'label' => 'Payment',
                'display_order' => 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 8,
                'key_name' => 'legal',
                'label' => 'Legal',
                'display_order' => 8,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 9,
                'key_name' => 'ticket',
                'label' => 'Ticket',
                'display_order' => 9,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 10,
                'key_name' => 'branding',
                'label' => 'Branding',
                'display_order' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
