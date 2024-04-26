<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Yui\Core\Database\Connection;

// Start the session
session_start();

echo "Starting the application..." . PHP_EOL;

// Connection::connect('/home/dre/_PROG/PHP/Yui/Core/db.sqlite');
Connection::connect();
