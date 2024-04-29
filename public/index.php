<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Yui\Core\Database\DatabaseInitializer;
use Yui\Core\Yui;

// Start the session
session_start();

// Se for passado por CLI o comando "php public/index.php create-db" ele irá criar o banco de dados
if ($argc > 1 && $argv[1] === 'create-db') {
    DatabaseInitializer::init();
    exit;
}

Yui::boot();