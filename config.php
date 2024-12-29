<?php
// /config.php

return [
    'queue_driver' => 'file', // Options: 'file' or 'database'
    'storage_path' => '../storage', // For file-based queue
    // Database connection settings
    'db' => [
        'host' => 'localhost',
        'port' => 3306,
        'database' => 'queue_system',
        'username' => 'root',
        'password' => '',
        'charset' => 'utf8mb4',
    ],
];
