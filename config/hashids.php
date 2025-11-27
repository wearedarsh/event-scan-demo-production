<?php

return [
    'default' => 'main',

    'connections' => [
        'checkin' => [
            'salt' => env('EVENT_SCAN_CHECK_IN_ENCRYPTION_KEY'),
            'length' => 10
        ],
    ],
];

?>
