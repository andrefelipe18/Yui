<?php

declare(strict_types=1);
use Yui\Core\Database\Drivers\Pgsql;

$config = [
    'host' => '127.0.0.1',
    'dbname' => 'test',
    'user' => 'root',
    'pass' => 'root',
    'port' => '5432',
];

test('successful connection', function () use ($config) {
    extract($config);

    $connection = Pgsql::connect($host, $dbname, $user, $pass, $port);

    expect($connection)->toBeInstanceOf(PDO::class);
});

test('connection failure', function () use ($config) {
    extract($config);
    $dbname = 'wrong_database_name';

    $connection = Pgsql::connect($host, $dbname, $user, $pass, $port);

    expect($connection)->toBeInstanceOf(PDOException::class);
    expect($connection->getMessage())->toMatch("/SQLSTATE\[08006\] \[7\] connection to server at \"(.*)\", port 5432 failed: FATAL:  database \"wrong_database_name\" does not exist/");
});

test('authentication failure', function () use ($config) {
    extract($config);
    $pass = 'wrong_password';

    $connection = Pgsql::connect($host, $dbname, $user, $pass, $port);

    expect($connection)->toBeInstanceOf(PDOException::class);
    expect($connection->getMessage())->toMatch("/SQLSTATE\[08006\] \[7\] connection to server at \"(.*)\", port 5432 failed: FATAL:  password authentication failed for user \"root\"/");
});

test('invalid port', function () use ($config) {
    extract($config);
    $port = '5433';

    $connection = Pgsql::connect($host, $dbname, $user, $pass, $port);

    expect($connection)->toBeInstanceOf(PDOException::class);
    expect($connection->getMessage())->toMatch("/SQLSTATE\[08006\] \[7\] connection to server at \"(.*)\", port 5433/");
});

test('database failure', function () use ($config) {
    extract($config);
    $host = '1';

    $connection = Pgsql::connect($host, $dbname, $user, $pass, $port, 1);

    expect($connection)->toBeInstanceOf(PDOException::class);
    expect($connection->getMessage())->toMatch("/SQLSTATE\[08006\] \[7\] connection to server at \"1\" \(0.0.0.1\), port 5432 failed: timeout expired/");
});
