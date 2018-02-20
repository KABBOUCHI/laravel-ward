<?php

return [
    'prefix' => env('LOG_VIEWER_PREFIX', 'log-viewer:'),
    'uri'    => env('LOG_VIEWER_URI', 'logs'),
    'middleware'    => env('LOG_VIEWER_MIDDLEWARE', 'web'),
];