<?php
return [

    'paths' => ['api/*', 'sanctum/csrf-cookie'], // allow all API routes

    'allowed_methods' => ['*'], // GET, POST, PUT, DELETE, etc.

    'allowed_origins' => ['http://localhost:5173'], // React dev server
    // or '*' to allow all (not recommended for production)

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'], // allow all headers including Authorization

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true, // set true if using cookies/auth
];
