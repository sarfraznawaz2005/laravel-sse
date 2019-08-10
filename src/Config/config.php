<?php

return [

    // enable or disable SSE
    'enabled' => env('SSE_ENABLED', true),

    // polling interval in seconds between requests
    'interval' => env('SSE_INTERVAL', 15),

    // append logged user id in SSE response
    'append_user_id' => env('SSE_APPEND_USER_ID', true),

    // keep events log in database
    'keep_events_logs' => env('SSE_KEEP_EVENTS_LOGS', false),

    // notification settings
    'position' => 'bottomRight', // top, topLeft, topCenter, topRight, center, centerLeft, centerRight, bottom, bottomLeft, bottomCenter, bottomRight
    'timeout' => false, // false, 1000, 3000, 3500, etc. Delay for closing event in milliseconds (ms). Set 'false' for sticky notifications.
];
