<?php

namespace Database\Seeders\Branding;

use Illuminate\Database\Seeder;
use App\Models\BrandingCss;
use App\Models\BrandingPlatform;

class BrandingCssSeeder extends Seeder
{
    public function run(): void
    {
        $cssMap = [
            'frontend' => '
:root {
  --color-bg: #F9FAFB;
  --color-surface: #FFFFFF;
  --color-primary: #1A4AFF;
  --color-primary-hover: #163ECC;
  --color-accent: #00C7B7;
  --color-accent-light: #E8F8F6;
  --color-text: #1E293B;
  --color-text-light: #64748B;
  --color-border: #E2E8F0;
  --color-gradient: linear-gradient(135deg, #1A4AFF 0%, #00C7B7 100%);
  --color-secondary: #0f1724;

  --color-success: #16A34A;
  --color-warning: #F59E0B;
  --color-danger: #DC2626;
  --color-muted: #94A3B8;
  --color-surface-hover: #F3F4F6;
}
',

            'registration' => '
:root {
  --color-bg: #F9FAFB;
  --color-surface: #FFFFFF;
  --color-primary: #1A4AFF;
  --color-primary-hover: #163ECC;
  --color-accent: #00C7B7;
  --color-accent-light: #E8F8F6;
  --color-text: #1E293B;
  --color-text-light: #64748B;
  --color-border: #E2E8F0;
  --color-gradient: linear-gradient(135deg, #1A4AFF 0%, #00C7B7 100%);
  --color-secondary: #0f1724;

  --color-success: #16A34A;
  --color-warning: #F59E0B;
  --color-danger: #DC2626;
  --color-muted: #94A3B8;
  --color-surface-hover: #F3F4F6;
}
',

            'backend_admin' => '
:root {
  --color-bg: #F9FAFB;
  --color-surface: #FFFFFF;
  --color-primary: #1A4AFF;
  --color-primary-hover: #163ECC;
  --color-accent: #00C7B7;
  --color-accent-light: #E8F8F6;
  --color-text: #1E293B;
  --color-text-light: #64748B;
  --color-border: #E2E8F0;
  --color-gradient: linear-gradient(135deg, #1A4AFF 0%, #00C7B7 100%);
  --color-secondary: #0f1724;

  --color-success: #16A34A;
  --color-warning: #F59E0B;
  --color-danger: #DC2626;
  --color-info: #0EA5E9;
  --color-neutral: #94A3B8;
  --color-muted: #94A3B8;
  --color-surface-hover: #F3F4F6;
}
',

            'backend_customer' => '
:root {
  --color-bg: #F9FAFB;
  --color-surface: #FFFFFF;
  --color-primary: #1A4AFF;
  --color-primary-hover: #163ECC;
  --color-accent: #00C7B7;
  --color-accent-light: #E8F8F6;
  --color-text: #1E293B;
  --color-text-light: #64748B;
  --color-border: #E2E8F0;
  --color-gradient: linear-gradient(135deg, #1A4AFF 0%, #00C7B7 100%);
  --color-secondary: #0f1724;

  --color-success: #16A34A;
  --color-warning: #F59E0B;
  --color-danger: #DC2626;
  --color-muted: #94A3B8;
  --color-surface-hover: #F3F4F6;
}
',
        ];

        foreach ($cssMap as $platformKey => $css) {
            $platform = BrandingPlatform::where('key_name', $platformKey)->first();

            if (! $platform) {
                continue;
            }

            BrandingCss::updateOrCreate(
                [
                    'branding_platform_id' => $platform->id,
                    'version' => 1,
                ],
                [
                    'key_name' => "{$platformKey}",
                    'name' => ucfirst(str_replace('_', ' ', $platformKey)) . ' default branding',
                    'css' => trim($css),
                    'is_active' => true,
                ]
            );
        }
    }
}
