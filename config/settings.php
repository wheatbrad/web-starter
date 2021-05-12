<?php

// Error reporting for development
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Error reporting for production
// error_reporting(0);
// ini_set('display_errors', '0');

date_default_timezone_set('America/New_York');

$settings = [];

// Error handling middleware settings
$settings['error'] = [
    // Set to false in production
    'display_error_details' => true,
    'log_errors' => true,

    // Display error details in error log
    'log_error_details' => true
];

$settings['db'] = [
    'driver' => 'mysql',
    'host' => 'localhost',
    'username' => '',
    'database' => '',
    'password' => '',
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'flags' => [
        // Turn off persistent connections
        PDO::ATTR_PERSISTENT => false,
        // Enable exceptions
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        // Emulate prepared statements
        PDO::ATTR_EMULATE_PREPARES => true,
        // Set default fetch mode to object
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        // Set character set
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci'
    ]
];

return $settings;