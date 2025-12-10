<?php

return [

    'contact_details' => [
        'booking_website_support_email' => env('BOOKING_WEBSITE_SUPPORT_EMAIL', 'support@eventscan.co.uk'),
        'booking_website_phone_number' => env('BOOKING_WEBSITE_PHONE_NUMBER', ''),
        'booking_website_company_name' => env('BOOKING_WEBSITE_COMPANY_NAME', 'Eventscan'),
        'booking_website_company_details' => env('BOOKING_WEBSITE_COMPANY_DETAILS', '')
    ],
    'custom_details' => [
        'invoice_prefix' => env('CUSTOMER_INVOICE_PREFIX')
    ]

];

