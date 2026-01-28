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
            'frontend' => <<<CSS
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
CSS,

            'registration' => <<<CSS
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
CSS,

            'backend_admin' => <<<CSS
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
CSS,

            'backend_customer' => <<<CSS
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
CSS,

            'email' => <<<CSS
body {
    margin: 0;
    padding: 0;
    background-color: #F3F5F8;
    font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif;
    line-height: 1.5;
    color: #0D4261;
    -webkit-text-size-adjust: none;
}

table {
    border-collapse: collapse;
}

h1,
p {
    font-size: 16px;
}

.email-wrapper {
    width: 100%;
    background-color: #F3F5F8;
}

.email-content {
    max-width: 600px;
    margin: 0 auto;
    background-color: #FFFFFF;
}

.email-masthead {
    background-color: #0D4261;
    text-align: center;
    padding: 25px 20px;
}

.email-masthead img {
    max-width: 200px;
    height: auto;
}

.email-body {
    padding: 30px 40px;
}

.email-footer {
    text-align: center;
    color: #FFFFFF;
    padding: 35px 20px;
    background-color: #0D4261;
}

.email-footer p {
    font-size: 12px;
}

.preheader {
    display: none !important;
    visibility: hidden;
    opacity: 0;
    height: 0;
    width: 0;
    font-size: 0;
    line-height: 0;
}

@media only screen and (max-width: 600px) {
    .email-body {
        padding: 20px 15px;
    }

    .email-masthead,
    .email-footer {
        padding-left: 15px !important;
        padding-right: 15px !important;
    }
}
CSS,
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
                    'key_name'  => $platformKey,
                    'name'      => ucfirst(str_replace('_', ' ', $platformKey)) . ' default branding',
                    'css'       => trim($css),
                    'is_active' => true,
                ]
            );
        }
    }
}
