<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'],

    'allowed_origins' => [
        'http://localhost:5173', // <-- PASTIKAN BARIS INI ADA DAN TIDAK ADA TYPO
        // Jika Anda juga mengakses backend via donasi-dm.test dari browser, Anda bisa tambahkan juga:
        // 'http://donasi-dm.test',
        // Untuk debugging cepat, Anda bisa pakai '*' TAPI JANGAN UNTUK PRODUCTION:
        // '*',
    ],

    'allowed_methods' => ['*'], // Izinkan semua metode (GET, POST, PUT, DELETE, OPTIONS)
    'allowed_headers' => ['*'], // Izinkan semua header
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true, // Penting untuk Sanctum/Passport dan Cookies/Auth Headers

    'allowed_origins_patterns' => [],

];
