<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */
    'stripe' => [
        'webhook_secret' => env('STRIPE_WEBHOOK_SECRET'),
        'secret' => env('STRIPE_SECRET'),
        'public' => env('STRIPE_PUBLIC'),
        'payment_link' => env('STRIPE_PAYMENT_LINK'),
    ],

    'ckeditor' => [
        'api_key' => env('CKEDITOR_API_KEY'),
    ],

    'emailblaster' => [
        'api_key' => env('EMAILBLASTER_API_KEY'),
        'base_url' => env('EMAILBLASTER_API_URL'),
        'marketing_list_id' => env('EMAILBLASTER_MARKETING_LIST_ID'),
        'folder' => env('EMAIL_BLASTER_FOLDER')
    ],

    'eventscan' => [
        'client_id' => env('EVENT_SCAN_CLIENT_ID'),
        'request_ip_address' => env('EVENT_SCAN_SERVER_IP'),
        'check_in_encryption_key' => env('EVENT_SCAN_CHECK_IN_ENCRYPTION_KEY'),
        'webhook_uuid' => env('EVENT_SCAN_WEBHOOK_UUID')
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

];
