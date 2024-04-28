<?php

declare(strict_types=1);
use Yui\Core\Database\Drivers\Pgsql;

test('successful connection', function () {
    $host = '127.0.0.1';
    $dbname = 'test';
    $user = 'root';
    $pass = 'root';
    $port = '5432';
    $connection = Pgsql::connect($host, $dbname, $user, $pass, $port);

    expect($connection)->toBeInstanceOf(PDO::class);
});

test('connection failure', function () {
    $host = '127.0.0.1';
    $dbname = 'wrong_database_name';
    $user = 'root';
    $pass = 'root';
    $port = '5432';

    $connection = Pgsql::connect($host, $dbname, $user, $pass, $port);

    expect($connection)->toBeInstanceOf(PDOException::class);
    expect($connection->getMessage())->toMatch("/SQLSTATE\[08006\] \[7\] connection to server at \"(.*)\", port 5432 failed: FATAL:  database \"wrong_database_name\" does not exist/");
});

test('authentication failure', function () {
    $host = '127.0.0.1';
    $dbname = 'test';
    $user = 'root';
    $pass = 'wrong_password';
    $port = '5432';

    $connection = Pgsql::connect($host, $dbname, $user, $pass, $port);

    expect($connection)->toBeInstanceOf(PDOException::class);
    expect($connection->getMessage())->toMatch("/SQLSTATE\[08006\] \[7\] connection to server at \"(.*)\", port 5432 failed: FATAL:  password authentication failed for user \"root\"/");
});

test('invalid port', function () {
    $host = '127.0.0.1';
    $dbname = 'test';
    $user = 'root';
    $pass = 'root';
    $port = '5433';

    $connection = Pgsql::connect($host, $dbname, $user, $pass, $port);

    expect($connection)->toBeInstanceOf(PDOException::class);
    expect($connection->getMessage())->toMatch("/SQLSTATE\[08006\] \[7\] connection to server at \"(.*)\", port 5433/");
});

test('database failure', function () {
    $host = '1';
    $dbname = 'wrong_database';
    $user = 'root';
    $pass = 'wrong_password';
    $port = '5432';

    $connection = Pgsql::connect($host, $dbname, $user, $pass, $port, 1);

    expect($connection)->toBeInstanceOf(PDOException::class);
    expect($connection->getMessage())->toMatch("/SQLSTATE\[08006\] \[7\] connection to server at \"1\" \(0.0.0.1\), port 5432 failed: timeout expired/");
});
