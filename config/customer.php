<?php

return [
    'financial' => [
        'bank_transfer_details' => env('BOOKING_WEBSITE_BANK_TRANSFER_DETAILS')
    ],
    'custom_details' => [
        'friendly_name' => env('CUSTOMER_ADMIN_FRIENDLY_NAME')
    ],
    'email' => [
        'transactional_signature' => env('CUSTOMER_TRANSACTIONAL_EMAIL_SIGNATURE', '')
    ]

];

