<?php

declare(strict_types=1);
use Yui\Core\Database\Connection;
use Yui\Core\Helpers\Dotenv;
use Yui\Core\Helpers\RootFinder;

/**
 * After Running a test method, tearDown() method is called.
 */
afterEach(function () {
    if (file_exists('.env.test')) {
  			unlink('.env.test');
  		}
    Dotenv::unset();
    Connection::disconnect();

});
test('connect with sqlite', function () {
    file_put_contents('.env.test', "DATABASE_CONNECTION=sqlite");
    $envPath = RootFinder::findRootFolder(__DIR__) . '/.env.test';
    $path = RootFinder::findRootFolder(__DIR__) . '/db.sqlite';

    $connection = Connection::connect(pathToSqlite: $path, envPath: $envPath);

    expect($connection)->toBeInstanceOf(\PDO::class);
});
test('exception  is  thrown  when  path  to  sqlite  file  is  not  set', function () {
    file_put_contents('.env.test', "DATABASE_CONNECTION=sqlite");
    $envPath = RootFinder::findRootFolder(__DIR__) . '/.env.test';

    $this->expectException(Exception::class);
    $this->expectExceptionMessage("Path to SQLite file is not set");

    Connection::connect(envPath: $envPath);
});
test('connect with mysql', function () {
    file_put_contents('.env.test', "DATABASE_CONNECTION=mysql\nDATABASE_HOST=127.0.0.1\nDATABASE_NAME=test\nDATABASE_USER=root\nDATABASE_PASSWORD=root\nDATABASE_PORT=3306");
    $envPath = RootFinder::findRootFolder(__DIR__) . '/.env.test';

    $connection = Connection::connect(envPath: $envPath);

    expect($connection)->toBeInstanceOf(PDO::class);
});
test('exception  is  thrown  when  mysql  connection  fail', function () {
    file_put_contents('.env.test', "DATABASE_CONNECTION=mysql\nDATABASE_HOST=127.0.0.1\nDATABASE_NAME=dasdsadasasd\nDATABASE_USER=root\nDATABASE_PASSWORD=root\nDATABASE_PORT=3306");
    $envPath = RootFinder::findRootFolder(__DIR__) . '/.env.test';

    $this->expectException(Exception::class);
    $this->expectExceptionMessage("Failed to connect to database: SQLSTATE[HY000] [1049] Unknown database 'dasdsadasasd'");

    Connection::connect(envPath: $envPath);
});
test('connect with pgsql', function () {
    file_put_contents('.env.test', "DATABASE_CONNECTION=pgsql\nDATABASE_HOST=127.0.0.1\nDATABASE_NAME=test\nDATABASE_USER=root\nDATABASE_PASSWORD=root\nDATABASE_PORT=5432");
    $envPath = RootFinder::findRootFolder(__DIR__) . '/.env.test';

    $connection = Connection::connect(envPath: $envPath);

    expect($connection)->toBeInstanceOf(PDO::class);
});
test('exception  is  thrown  when  pgsql  connection  fail', function () {
    file_put_contents('.env.test', "DATABASE_CONNECTION=pgsql\nDATABASE_HOST=127.0.0.1\nDATABASE_NAME=tesasdsaasdt\nDATABASE_USER=root\nDATABASE_PASSWORD=root\nDATABASE_PORT=5432");
    $envPath = RootFinder::findRootFolder(__DIR__) . '/.env.test';

    $this->expectException(Exception::class);
    $this->expectExceptionMessage('SQLSTATE[08006] [7] connection to server at "127.0.0.1", port 5432 failed: FATAL:  database "tesasdsaasdt" does not exist');

    Connection::connect(envPath: $envPath);
});
test('exception  is  thrown  when  connection  type  is  not  supported', function () {
    file_put_contents('.env.test', "DATABASE_CONNECTION=mongodb");
    $envPath = RootFinder::findRootFolder(__DIR__) . '/.env.test';

    $this->expectException(Exception::class);
    $this->expectExceptionMessage("Database connection type is not supported");

    Connection::connect(envPath: $envPath);
});
test('exception  is  thrown  when  database  connection  parameters  are  missing', function () {
    file_put_contents('.env.test', "DATABASE_CONNECTION=mysql");
    $envPath = RootFinder::findRootFolder(__DIR__) . '/.env.test';

    $this->expectException(Exception::class);
    $this->expectExceptionMessage("Database connection parameters are not set in the .env file");

    Connection::connect(envPath: $envPath);
});
test('disconnect', function () {
    $connection = Connection::connect();
    $connection = Connection::disconnect();

    expect($connection)->toBeNull();
});
test('reusing connection', function () {
    $connection = Connection::connect();
    $connection2 = Connection::connect();

    expect($connection2)->toBe($connection);
});
test('expection is thrown when trying to connect non existing database', function () {
    file_put_contents('.env.test', "DATABASE_CONNECTION=mysql\nDATABASE_HOST=127.0.0.1\nDATABASE_NAME=NonExistsDB\nDATABASE_USER=root\nDATABASE_PASSWORD=root\nDATABASE_PORT=3306");
    $envPath = RootFinder::findRootFolder(__DIR__) . '/.env.test';

    $this->expectException(Exception::class);
    $this->expectExceptionMessage("Failed to connect to database: SQLSTATE[HY000] [1049] Unknown database 'NonExistsDB'");

    Connection::connect(envPath: $envPath);
});
test('expection is thrown when trying to connect with invalid credentials', function () {
    file_put_contents('.env.test', "DATABASE_CONNECTION=mysql\nDATABASE_HOST=127.0.0.1\nDATABASE_NAME=NonExistsDB\nDATABASE_USER=root\nDATABASE_PASSWORD=wrongpassword\nDATABASE_PORT=3306");
    $envPath = RootFinder::findRootFolder(__DIR__) . '/.env.test';

    $this->expectException(Exception::class);
    $this->expectExceptionMessageMatches("/Failed to connect to database: SQLSTATE\[HY000\] \[1045\] Access denied for user 'root'@'(.*)' \(using password: YES\)/");

    Connection::connect(envPath: $envPath);
});
test('exception is thrown when database connection fails', function () {
    file_put_contents('.env.test', "DATABASE_CONNECTION=mysql\nDATABASE_HOST=1\nDATABASE_NAME=NonExistsDB\nDATABASE_USER=root\nDATABASE_PASSWORD=wrongpassword\nDATABASE_PORT=3306");
    $envPath = RootFinder::findRootFolder(__DIR__) . '/.env.test';

    $this->expectException(Exception::class);
    $this->expectExceptionMessage("Failed to connect to database: SQLSTATE[HY000] [2002] Connection timed out");

    Connection::connect(envPath: $envPath, timeout: 1);
}); 
