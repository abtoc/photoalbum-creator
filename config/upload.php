<?php

return [
    'companion_url' => env('UPLOAD_COMPANION_URL'),
    'max_file_size' => env('UPLOAD_MAX_FILE_SIZE', 2000000),
    'count' => env('UPLOAD_COUNT', 100),
    'limit' => env('UPLOAD_LIMIT', 5),
    'timeout' => env('UPLOAD_TIMEOUT', 30000),
];