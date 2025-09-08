<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],
    'allowed_methods' => ['*'],

    // Origin FE yang diizinkan
    'allowed_origins' => [
        'http://localhost:3000',
        'http://127.0.0.1:3000',
        // Tambahkan domain produksi jika ada, mis: 'https://www.domainmu.com',
    ],

    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,

    // Tetap false karena FE kamu tanpa login/cookie
    'supports_credentials' => false,
];
