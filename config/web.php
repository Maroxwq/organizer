<?php declare(strict_types=1);

return [
    'base_path' => realpath(__DIR__ . '/../'),
    'base_namespace' => '\\Org\\',
    'routes' => require 'routes.php',
    'db' => require 'db.php',
    'security' => [
        'private_urls' => ['/^\//'],
        'public_urls' => ['/^\/register/', '/^\/login/', '/^\/about/'],
        'login_url' => '/login',
    ],
];
