<?php 

    return [
        'scheme' => env('CHECK_IN_APP_SCHEME'),
        'auth_token' => env('CHECK_IN_APP_AUTH_TOKEN'),
        'apple_download_url' => env('CHECK_IN_APP_APPLE_DOWNLOAD_URL'),
        'android_download_url' => env('CHECK_IN_APP_ANDROID_DOWNLOAD_URL'),
        'qr_prefix' => env('CHECK_IN_APP_PREFIX'),
        'friendly_name' => env('CHECK_IN_APP_FRIENDLY_NAME'),
        'privacy_email' => env('CHECK_IN_APP_PRIVACY_EMAIL'),
        'support_email' => env('CHECK_IN_APP_SUPPORT_EMAIL')
    ];

?>