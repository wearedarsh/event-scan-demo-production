<?php

namespace Database\Seeders\ClientSetting;

use Illuminate\Database\Seeder;
use App\Models\ClientSetting;

class ClientSettingBrandingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [

            [
                'category_id'   => 1,
                'key_name'      => 'branding.frontend.logo.path',
                'label'         => 'Frontend main logo path',
                'display_order' => 1,
                'type'          => 'text',
                'value'         => '/storage/branding/logo-frontend.png',
            ],
            [
                'category_id'   => 1,
                'key_name'      => 'branding.frontend.logo_white.path',
                'label'         => 'Frontend main logo (white) path',
                'display_order' => 2,
                'type'          => 'text',
                'value'         => '/storage/branding/logo-white-frontend.png',
            ],
            [
                'category_id'   => 1,
                'key_name'      => 'branding.frontend.registration_logo.path',
                'label'         => 'Frontend registration logo path',
                'display_order' => 3,
                'type'          => 'text',
                'value'         => '/storage/branding/logo-registration-frontend.png',
            ],
            [
                'category_id'   => 1,
                'key_name'      => 'branding.frontend.auth_logo.path',
                'label'         => 'Frontend auth/login logo path',
                'display_order' => 4,
                'type'          => 'text',
                'value'         => '/storage/branding/logo-auth-frontend.png',
            ],
            [
                'category_id'   => 1,
                'key_name'      => 'branding.frontend.favicon.path',
                'label'         => 'Frontend favicon path',
                'display_order' => 5,
                'type'          => 'text',
                'value'         => '/storage/branding/favicon-frontend.svg',
            ],
            [
                'category_id'   => 1,
                'key_name'      => 'branding.frontend.registration_favicon.path',
                'label'         => 'Frontend registration favicon path',
                'display_order' => 6,
                'type'          => 'text',
                'value'         => '/storage/branding/favicon-registration.svg',
            ],
            [
                'category_id'   => 1,
                'key_name'      => 'branding.frontend.header_background.path',
                'label'         => 'Frontend header background path',
                'display_order' => 7,
                'type'          => 'text',
                'value'         => '/storage/branding/header-bg-frontend.jpg',
            ],
            [
                'category_id'   => 1,
                'key_name'      => 'branding.frontend.login_background.path',
                'label'         => 'Frontend login background path',
                'display_order' => 8,
                'type'          => 'text',
                'value'         => '/storage/branding/login-full-bg-frontend.jpg',
            ],

            [
                'category_id'   => 1,
                'key_name'      => 'branding.backend.admin_logo.path',
                'label'         => 'Backend admin logo path',
                'display_order' => 10,
                'type'          => 'text',
                'value'         => '/storage/branding/logo-admin-backend.png',
            ],
            [
                'category_id'   => 1,
                'key_name'      => 'branding.backend.customer_logo.path',
                'label'         => 'Backend customer logo path',
                'display_order' => 11,
                'type'          => 'text',
                'value'         => '/storage/branding/logo-customer-backend.png',
            ],
            [
                'category_id'   => 1,
                'key_name'      => 'branding.backend.admin_favicon.path',
                'label'         => 'Backend admin favicon path',
                'display_order' => 12,
                'type'          => 'text',
                'value'         => '/storage/branding/favicon-admin-backend.svg',
            ],
            [
                'category_id'   => 1,
                'key_name'      => 'branding.backend.customer_favicon.path',
                'label'         => 'Backend customer favicon path',
                'display_order' => 13,
                'type'          => 'text',
                'value'         => '/storage/branding/favicon-customer-backend.svg',
            ],

            [
                'category_id'   => 1,
                'key_name'      => 'branding.frontend.auth_favicon.path',
                'label'         => 'Frontend auth/login favicon path',
                'display_order' => 14,
                'type'          => 'text',
                'value'         => '/storage/branding/favicon-auth-frontend.svg',
            ],
        ];

        foreach ($settings as $setting) {
            ClientSetting::updateOrCreate(
                ['key_name' => $setting['key_name']],
                $setting
            );
        }
    }
}
