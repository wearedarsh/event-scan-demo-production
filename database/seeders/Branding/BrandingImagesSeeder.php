<?php

namespace Database\Seeders\Branding;

use Illuminate\Database\Seeder;
use App\Models\BrandingImage;
use App\Models\BrandingPlatform;
use Illuminate\Support\Facades\Storage;

class BrandingImagesSeeder extends Seeder
{
    public function run(): void
    {
        $sourcePath = database_path('seeders/branding/branding_files');
        $destinationPath = 'public/branding';

        $platforms = [
            'frontend' => BrandingPlatform::where('key_name', 'frontend')->first(),
            'backend'  => BrandingPlatform::where('key_name', 'backend')->first(),
        ];

        $images = [
            ['platform' => 'frontend', 'key_name' => 'frontend_logo', 'file' => 'logo-frontend.png', 'alt' => 'Frontend logo'],
            ['platform' => 'frontend', 'key_name' => 'frontend_logo_white', 'file' => 'logo-white-frontend.png', 'alt' => 'Frontend logo (white)'],
            ['platform' => 'frontend', 'key_name' => 'registration_logo', 'file' => 'logo-registration-frontend.png', 'alt' => 'Registration logo'],
            ['platform' => 'backend',  'key_name' => 'admin_logo_backend', 'file' => 'logo-admin-backend.png', 'alt' => 'Admin backend logo'],
            ['platform' => 'backend',  'key_name' => 'customer_logo_backend', 'file' => 'logo-customer-backend.png', 'alt' => 'Customer backend logo'],
            ['platform' => 'backend',  'key_name' => 'auth_logo_frontend', 'file' => 'logo-auth-frontend.png', 'alt' => 'Auth frontend logo'],
            ['platform' => 'frontend', 'key_name' => 'frontend_favicon', 'file' => 'favicon-frontend.svg', 'alt' => 'Frontend favicon'],
            ['platform' => 'frontend', 'key_name' => 'registration_favicon', 'file' => 'favicon-registration.svg', 'alt' => 'Registration favicon'],
            ['platform' => 'backend',  'key_name' => 'auth_favicon_frontend', 'file' => 'favicon-auth-frontend.svg', 'alt' => 'Auth frontend favicon'],
            ['platform' => 'backend',  'key_name' => 'admin_favicon_backend', 'file' => 'favicon-admin-backend.svg', 'alt' => 'Admin backend favicon'],
            ['platform' => 'backend',  'key_name' => 'customer_favicon_backend', 'file' => 'favicon-customer-backend.svg', 'alt' => 'Customer backend favicon'],
            ['platform' => 'frontend', 'key_name' => 'frontend_header_background', 'file' => 'header-bg-frontend.jpg', 'alt' => 'Frontend header background'],
            ['platform' => 'frontend', 'key_name' => 'frontend_login_background', 'file' => 'login-full-bg-frontend.jpg', 'alt' => 'Frontend login background'],
        ];

        foreach ($images as $img) {
            $platform = $platforms[$img['platform']] ?? null;
            if (!$platform) continue;

            $sourceFile = "{$sourcePath}/{$img['file']}";
            $storagePath = "{$destinationPath}/{$img['file']}";

            if (file_exists($sourceFile) && !Storage::exists($storagePath)) {
                Storage::putFileAs($destinationPath, $sourceFile, $img['file']);
            }

            BrandingImage::updateOrCreate(
                [
                    'branding_platform_id' => $platform->id,
                    'key_name' => $img['key_name'],
                ],
                [
                    'path' => "/storage/branding/{$img['file']}",
                    'alt_text' => $img['alt'],
                ]
            );
        }
    }
}
