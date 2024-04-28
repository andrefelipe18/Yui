<?php

declare(strict_types=1);
use Yui\Core\Database\Drivers\Mysql;

$config = [
    'host' => '127.0.0.1',
    'dbname' => 'test',
    'user' => 'root',
    'pass' => 'root',
    'port' => '3306',
];

test('successful connection', function () use ($config) {
    extract($config);
    
    $connection = Mysql::connect($host, $dbname, $user, $pass, $port);

    expect($connection)->toBeInstanceOf(PDO::class);
});

test('connection failure', function () use ($config) {
    extract($config);
    $dbname = 'wrong_database';

    $connection = Mysql::connect($host, $dbname, $user, $pass, $port);

    expect($connection)->toBeInstanceOf(PDOException::class);
    expect($connection->getMessage())->toMatch("/SQLSTATE\[HY000\] \[1049\] Unknown database '(.*)'/");
});

test('authentication failure', function () use ($config) {
    extract($config);
    $pass = 'wrong_password';

    $connection = Mysql::connect($host, $dbname, $user, $pass, $port);

    expect($connection)->toBeInstanceOf(PDOException::class);
    expect($connection->getMessage())->toMatch("/SQLSTATE\[HY000\] \[1045\] Access denied for user '(.*)'@'(.*)' \(using password: YES\)/");
});

test('invalid port', function () use ($config) {
    extract($config);
    $port = '3307';

    $connection = Mysql::connect($host, $dbname, $user, $pass, $port);

    expect($connection)->toBeInstanceOf(PDOException::class);
    expect($connection->getMessage())->toMatch("/SQLSTATE\[HY000\] \[2002\] Connection refused/");
});

test('database failure', function () use ($config) {
    extract($config);
    $host = '1';

    $connection = Mysql::connect($host, $dbname, $user, $pass, $port, 1);

    expect($connection)->toBeInstanceOf(PDOException::class);
    expect($connection->getMessage())->toMatch("/SQLSTATE\[HY000\] \[2002\] Connection timed out/");
});