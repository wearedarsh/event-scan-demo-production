<?php

use App\Models\BrandingCss;

if (! function_exists('branding_css')) {
    function branding_css(string $platformKey): ?string
    {
        static $cache = [];

        if (! array_key_exists($platformKey, $cache)) {
            $cache[$platformKey] = optional(
                BrandingCss::activeForPlatform($platformKey)
            )->css;
        }

        return $cache[$platformKey];
    }
}
