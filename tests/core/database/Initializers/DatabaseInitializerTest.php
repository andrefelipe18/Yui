<?php

declare(strict_types=1);

use Yui\Core\Database\Connection;
use Yui\Core\Database\DatabaseInitializer;
use Yui\Core\Database\Drivers\Mysql;
use Yui\Core\Exceptions\Database\DatabaseInitializerException;
use Yui\Core\Helpers\Dotenv;
use Yui\Core\Helpers\RootFinder; 

afterEach(function () {
    if (file_exists('.env.test')) {
        unlink('.env.test');
    }
    Dotenv::unset();
    Connection::disconnect();
});


test('successful initialization with mysql', function () {
    file_put_contents('.env.test', "DATABASE_CONNECTION=mysql\nDATABASE_HOST=127.0.0.1\nDATABASE_USER=root\nDATABASE_PASSWORD=root\nDATABASE_PORT=3306");
    $envPath = RootFinder::findRootFolder(__DIR__) . '/.env.test';

    DatabaseInitializer::init(envPath: $envPath);

    $pdo = Mysql::connect('127.0.0.1', 'yui', 'root', 'root', '3306');
    expect($pdo)->toBeInstanceOf(PDO::class);

    $pdo = null;

    $pdo = Mysql::connect('127.0.0.1', 'test', 'root', 'root', '3306');
    expect($pdo)->toBeInstanceOf(PDO::class);
});

test('fails initialization with mysql when credentials is invalid', function () {
    file_put_contents('.env.test', "DATABASE_CONNECTION=mysql\nDATABASE_HOST=127.0.0.1\nDATABASE_USER='wrongUser'\nDATABASE_PASSWORD=root\nDATABASE_PORT=3306");
    $envPath = RootFinder::findRootFolder(__DIR__) . '/.env.test';

    $this->expectException(PDOException::class);

    DatabaseInitializer::init(envPath: $envPath);
});

test('successful initialization with pgsql', function () {
    file_put_contents('.env.test', "DATABASE_CONNECTION=pgsql\nDATABASE_HOST=127.0.0.1\nDATABASE_USER=root\nDATABASE_PASSWORD=root\nDATABASE_PORT=5432");
    $envPath = RootFinder::findRootFolder(__DIR__) . '/.env.test';

    DatabaseInitializer::init(envPath: $envPath);

    $pdo = new PDO('pgsql:host=127.0.0.1;dbname=yui', 'root', 'root');
    expect($pdo)->toBeInstanceOf(PDO::class);

    $pdo = null;

    $pdo = new PDO('pgsql:host=127.0.0.1;dbname=test', 'root', 'root');
    expect($pdo)->toBeInstanceOf(PDO::class);
});

test('fails initialization with pgsql when credentials is invalid', function () {
    file_put_contents('.env.test', "DATABASE_CONNECTION=pgsql\nDATABASE_HOST=127.0.0.1\nDATABASE_USER='wrongUser'\nDATABASE_PASSWORD=root");
    $envPath = RootFinder::findRootFolder(__DIR__) . '/.env.test';

    $this->expectException(DatabaseInitializerException::class);

    DatabaseInitializer::init(envPath: $envPath);
});

test('exception thrown if database connection type is not supported', function () {
    file_put_contents('.env.test', "DATABASE_CONNECTION=wrongType");
    $envPath = RootFinder::findRootFolder(__DIR__) . '/.env.test';

    expect(fn () => DatabaseInitializer::init(envPath: $envPath))->toThrow(new DatabaseInitializerException('Database connection type is not supported'));
});

test('verify if PDO connection is created correctly with the provided configurations for MySQL and PostgreSQL', function () {
    file_put_contents('.env.test', "DATABASE_CONNECTION=\nDATABASE_HOST=127.0.0.1\nDATABASE_USER=root\nDATABASE_PASSWORD=root");
    $envPath = RootFinder::findRootFolder(__DIR__) . '/.env.test';

    expect(fn () => DatabaseInitializer::init(envPath: $envPath))->toThrow(new DatabaseInitializerException("Database connection type is not set in the .env file"));
});