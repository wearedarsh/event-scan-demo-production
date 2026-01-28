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
                'key_name'      => 'branding.frontend.logo.custom_classes',
                'label'         => 'Frontend logo custom classes',
                'display_order' => 2,
                'type'          => 'text',
                'value'         => 'width:200px',
            ],
            [
                'category_id'   => 1,
                'key_name'      => 'branding.frontend.logo_white.path',
                'label'         => 'Frontend main logo (white) path',
                'display_order' => 3,
                'type'          => 'text',
                'value'         => '/storage/branding/logo-white-frontend.png',
            ],
            [
                'category_id'   => 1,
                'key_name'      => 'branding.frontend.registration.logo.path',
                'label'         => 'Frontend registration logo path',
                'display_order' => 4,
                'type'          => 'text',
                'value'         => '/storage/branding/logo-registration-frontend.png',
            ],
            [
                'category_id'   => 1,
                'key_name'      => 'branding.frontend.registration.logo.custom_classes',
                'label'         => 'Frontend registration logo custom classes',
                'display_order' => 5,
                'type'          => 'text',
                'value'         => 'width:200px',
            ],
            [
                'category_id'   => 1,
                'key_name'      => 'branding.frontend.auth.logo.path',
                'label'         => 'Frontend auth/login logo path',
                'display_order' => 6,
                'type'          => 'text',
                'value'         => '/storage/branding/logo-auth-frontend.png',
            ],
            [
                'category_id'   => 1,
                'key_name'      => 'branding.frontend.auth.logo.custom_classes',
                'label'         => 'Frontend auth/login logo custom classes',
                'display_order' => 7,
                'type'          => 'text',
                'value'         => 'mx-auto w-56 mb-6',
            ],
            [
                'category_id'   => 1,
                'key_name'      => 'branding.frontend.favicon.path',
                'label'         => 'Frontend favicon path',
                'display_order' => 8,
                'type'          => 'text',
                'value'         => '/storage/branding/favicon-frontend.svg',
            ],
            [
                'category_id'   => 1,
                'key_name'      => 'branding.frontend.registration.favicon.path',
                'label'         => 'Frontend registration favicon path',
                'display_order' => 9,
                'type'          => 'text',
                'value'         => '/storage/branding/favicon-registration.svg',
            ],
            [
                'category_id'   => 1,
                'key_name'      => 'branding.frontend.header_background.path',
                'label'         => 'Frontend header background path',
                'display_order' => 10,
                'type'          => 'text',
                'value'         => '/storage/branding/header-bg-frontend.jpg',
            ],
            [
                'category_id'   => 1,
                'key_name'      => 'branding.frontend.auth.background.path',
                'label'         => 'Frontend auth background path',
                'display_order' => 11,
                'type'          => 'text',
                'value'         => '/storage/branding/login-full-bg-frontend.jpg',
            ],

            [
                'category_id'   => 1,
                'key_name'      => 'branding.backend.admin.logo.path',
                'label'         => 'Backend admin logo path',
                'display_order' => 12,
                'type'          => 'text',
                'value'         => '/storage/branding/logo-admin-backend.png',
            ],
            [
                'category_id'   => 1,
                'key_name'      => 'branding.backend.admin.logo.custom_classes',
                'label'         => 'Backend admin logo path',
                'display_order' => 13,
                'type'          => 'text',
                'value'         => '',
            ],
            [
                'category_id'   => 1,
                'key_name'      => 'branding.backend.customer.logo.path',
                'label'         => 'Backend customer logo path',
                'display_order' => 14,
                'type'          => 'text',
                'value'         => '/storage/branding/logo-customer-backend.png',
            ],
            [
                'category_id'   => 1,
                'key_name'      => 'branding.backend.customer.logo.custom_classes',
                'label'         => 'Backend customer logo path',
                'display_order' => 15,
                'type'          => 'text',
                'value'         => '',
            ],
            [
                'category_id'   => 1,
                'key_name'      => 'branding.backend.admin.favicon.path',
                'label'         => 'Backend admin favicon path',
                'display_order' => 16,
                'type'          => 'text',
                'value'         => '/storage/branding/favicon-admin-backend.svg',
            ],
            [
                'category_id'   => 1,
                'key_name'      => 'branding.backend.customer.favicon.path',
                'label'         => 'Backend customer favicon path',
                'display_order' => 17,
                'type'          => 'text',
                'value'         => '/storage/branding/favicon-customer-backend.svg',
            ],

            [
                'category_id'   => 1,
                'key_name'      => 'branding.frontend.auth_favicon.path',
                'label'         => 'Frontend auth/login favicon path',
                'display_order' => 18,
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
