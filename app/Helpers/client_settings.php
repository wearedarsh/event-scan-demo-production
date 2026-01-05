<?php

use App\Models\ClientSetting;

if (! function_exists('client_setting')) {
    function client_setting(string $key, $default = null)
    {
        static $settings;

        if (! $settings) {
            $settings = ClientSetting::pluck('value', 'key_name')->toArray();
        }

        return $settings[$key] ?? $default;
    }
}
