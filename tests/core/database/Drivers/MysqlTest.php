<?php

declare(strict_types=1);
use Yui\Core\Database\Drivers\Mysql;

test('successful connection', function () {
    $host = '127.0.0.1';
    $dbname = 'test';
    $user = 'root';
    $pass = 'root';
    $port = '3306';
    $connection = Mysql::connect($host, $dbname, $user, $pass, $port);

    expect($connection)->toBeInstanceOf(PDO::class);
});

test('connection failure', function () {
    $host = '127.0.0.1';
    $dbname = 'wrong_database_name';
    $user = 'root';
    $pass = 'root';
    $port = '3306';

    $connection = Mysql::connect($host, $dbname, $user, $pass, $port);

    expect($connection)->toBeInstanceOf(PDOException::class);
    expect($connection->getMessage())->toMatch("/SQLSTATE\[HY000\] \[1049\] Unknown database '(.*)'/");
});

test('authentication failure', function () {
    $host = '127.0.0.1';
    $dbname = 'test';
    $user = 'root';
    $pass = 'wrong_password';
    $port = '3306';

    $connection = Mysql::connect($host, $dbname, $user, $pass, $port);

    expect($connection)->toBeInstanceOf(PDOException::class);
    expect($connection->getMessage())->toMatch("/SQLSTATE\[HY000\] \[1045\] Access denied for user '(.*)'@'(.*)' \(using password: YES\)/");
});

test('invalid port', function () {
    $host = '127.0.0.1';
    $dbname = 'test';
    $user = 'root';
    $pass = 'root';
    $port = '3307';

    $connection = Mysql::connect($host, $dbname, $user, $pass, $port);

    expect($connection)->toBeInstanceOf(PDOException::class);
    expect($connection->getMessage())->toMatch("/SQLSTATE\[HY000\] \[2002\] Connection refused/");
});

test('database failure', function () {
    $host = '1';
    $dbname = 'wrong_database';
    $user = 'root';
    $pass = 'wrong_password';
    $port = '3306';

    $connection = Mysql::connect($host, $dbname, $user, $pass, $port, 1);

    expect($connection)->toBeInstanceOf(PDOException::class);
    expect($connection->getMessage())->toMatch("/SQLSTATE\[HY000\] \[2002\] Connection timed out/");
});