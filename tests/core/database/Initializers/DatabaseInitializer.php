<?php

declare(strict_types=1);

use Yui\Core\Database\Connection;
use Yui\Core\Database\Drivers\Mysql;
use Yui\Core\Database\Drivers\Pgsql;
use Yui\Core\Database\Drivers\Sqlite;
use Yui\Core\Database\Initializers\{DatabaseInitializer, SqliteDatabaseInitializer, MySQLDatabaseInitializer, PostgreSQLDatabaseInitializer};
use Yui\Core\Helpers\Dotenv;
use Yui\Core\Helpers\RootFinder;

afterEach(function () {
    if (file_exists('.env.test')) {
        unlink('.env.test');
    }
    Dotenv::unset();
    Connection::disconnect();
});

test('successful initialization with sqlite', function () {
    file_put_contents('.env.test', "DATABASE_CONNECTION=sqlite");
    $envPath = RootFinder::findRootFolder(__DIR__) . '/.env.test';
    $pathToSqlite = '/home/dre/_PROG/PHP/Yui/Core/db.sqlite';


    DatabaseInitializer::init(pathToSqlite: $pathToSqlite, envPath: $envPath);

    $pdo = Sqlite::connect($pathToSqlite);
    expect($pdo)->toBeInstanceOf(PDO::class);
});

test('exception thrown if sqlite path is not provided', function () {
    file_put_contents('.env.test', "DATABASE_CONNECTION=sqlite");
    $envPath = RootFinder::findRootFolder(__DIR__) . '/.env.test';

    expect(fn () => DatabaseInitializer::init(envPath: $envPath))->toThrow(new Exception('Path to SQLite file is not set'));
});


test('successful initialization with mysql', function () {
    file_put_contents('.env.test', "DATABASE_CONNECTION=mysql\nDATABASE_HOST=127.0.0.1\nDATABASE_USER=root\nDATABASE_PASSWORD=root");
    $envPath = RootFinder::findRootFolder(__DIR__) . '/.env.test';

    DatabaseInitializer::init(envPath: $envPath);

    $pdo = new PDO('mysql:host=127.0.0.1;dbname=yui', 'root', 'root');
    expect($pdo)->toBeInstanceOf(PDO::class);

    $pdo = null;

    $pdo = new PDO('mysql:host=127.0.0.1;dbname=test', 'root', 'root');
    expect($pdo)->toBeInstanceOf(PDO::class);
});

test('fails initialization with mysql when credentials is invalid', function () {
    file_put_contents('.env.test', "DATABASE_CONNECTION=mysql\nDATABASE_HOST=127.0.0.1\nDATABASE_USER='wrongUser'\nDATABASE_PASSWORD=root");
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

    $this->expectException(PDOException::class);

    DatabaseInitializer::init(envPath: $envPath);
});


test('exception thrown if database connection type is not set in the .env file', function () {
    file_put_contents('.env.test', "");
    $envPath = RootFinder::findRootFolder(__DIR__) . '/.env.test';

    expect(fn () => DatabaseInitializer::init(envPath: $envPath))->toThrow(new Exception('Database connection type is not set in the .env file'));
});

test('exception thrown if database connection type is not supported', function () {
    file_put_contents('.env.test', "DATABASE_CONNECTION=wrongType");
    $envPath = RootFinder::findRootFolder(__DIR__) . '/.env.test';

    expect(fn () => DatabaseInitializer::init(envPath: $envPath))->toThrow(new Exception('Database connection type is not supported'));
});

test('verify if PDO connection is created correctly with the provided configurations for MySQL and PostgreSQL', function () {
    file_put_contents('.env.test', "DATABASE_CONNECTION=\nDATABASE_HOST=127.0.0.1\nDATABASE_USER=root\nDATABASE_PASSWORD=root");
    $envPath = RootFinder::findRootFolder(__DIR__) . '/.env.test';

    expect(fn () => DatabaseInitializer::init(envPath: $envPath))->toThrow(new Exception("Database connection type is not set in the .env file"));
});

test('check if database and table are created correctly in sqlite', function () {
    file_put_contents('.env.test', "DATABASE_CONNECTION=sqlite");
    $envPath = RootFinder::findRootFolder(__DIR__) . '/.env.test';
    $pathToSqlite = '/home/dre/_PROG/PHP/Yui/Core/db.sqlite';

    DatabaseInitializer::init(pathToSqlite: $pathToSqlite, envPath: $envPath);

    $pdo = Sqlite::connect($pathToSqlite);

    $stmt = $pdo->query("SELECT name FROM sqlite_master WHERE type='table' AND name='users'");

    expect($stmt->fetchColumn())->toBe('users');
});

test('check if database and table are created correctly in mysql', function () {
    file_put_contents('.env.test', "DATABASE_CONNECTION=mysql\nDATABASE_HOST=127.0.0.1\nDATABASE_USER=root\nDATABASE_PASSWORD=root\nDATABASE_PORT=3306");
    $envPath = RootFinder::findRootFolder(__DIR__) . '/.env.test';

    DatabaseInitializer::init(envPath: $envPath);

    $pdo = Mysql::connect('127.0.0.1', 'yui', 'root', 'root', '3306');

    $stmt = $pdo->query("SELECT * FROM users");
    expect($stmt)->not->toBeFalse();

    $pdo = null;

    $pdo = Mysql::connect('127.0.0.1', 'test', 'root', 'root', '3306');

    $stmt = $stmt = $pdo->query("SELECT * FROM users");
    expect($stmt)->not->toBeFalse();
});

test('check if database and table are created correctly in pgsql', function () {
    file_put_contents('.env.test', "DATABASE_CONNECTION=pgsql\nDATABASE_HOST=127.0.0.1\nDATABASE_USER=root\nDATABASE_PASSWORD=root\nDATABASE_PORT=5432");
    $envPath = RootFinder::findRootFolder(__DIR__) . '/.env.test';

    DatabaseInitializer::init(envPath: $envPath);

    $pdo = Pgsql::connect('127.0.0.1', 'yui', 'root', 'root', '5432');

    $stmt = $pdo->query("SELECT * FROM users");
    expect($stmt)->not->toBeFalse();

    $pdo = null;

    $pdo = Pgsql::connect('127.0.0.1', 'test', 'root', 'root', '5432');

    $stmt = $pdo->query("SELECT * FROM users");
    expect($stmt)->not->toBeFalse();
});


test('getDriver() method returns the correct driver type for the SQLite database connection', function () {
    function getDriver($class)
    {
        $class = new ReflectionClass($class);

        $method = $class->getMethod('getDriver');

        $method->setAccessible(true);

        return $method->invoke($class);
    }

    $sqliteInitializer = new SqliteDatabaseInitializer();
    $mysqlInitializer = new MySQLDatabaseInitializer();
    $pgsqlInitializer = new PostgreSQLDatabaseInitializer();

    expect(getDriver($sqliteInitializer))->toBe('sqlite');
    expect(getDriver($mysqlInitializer))->toBe('mysql');
    expect(getDriver($pgsqlInitializer))->toBe('pgsql');
});