<?php

declare(strict_types=1);

namespace Tests\Yui\Core\Database;

use Exception;
use PDO;
use PDOException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Yui\Core\Database\Connection;
use Yui\Helpers\Dotenv;
use Yui\Helpers\RootFinder;

class ConnectionTest extends TestCase
{
	/**
	 * After Running a test method, tearDown() method is called.
	 */
	protected function tearDown(): void
	{
		unlink('.env.test');
		Dotenv::unset();
		Connection::disconnect();

		parent::tearDown();
	}

	#[Test]
	public function connect_with_sqlite()
	{
		file_put_contents('.env.test', "DATABASE_CONNECTION=sqlite");
		$envPath = RootFinder::findRootFolder(__DIR__) . '/.env.test';
		$path = RootFinder::findRootFolder(__DIR__) . '/db.sqlite';

		$connection = Connection::connect(pathToSqlite: $path, envPath: $envPath);

		$this->assertInstanceOf(\PDO::class, $connection);
	}

	#[Test]
	public function exception_Is_Thrown_When_Path_To_Sqlite_File_Is_Not_Set()
	{
		file_put_contents('.env.test', "DATABASE_CONNECTION=sqlite");
		$envPath = RootFinder::findRootFolder(__DIR__) . '/.env.test';

		$this->expectException(Exception::class);
		$this->expectExceptionMessage("Path to SQLite file is not set");

		Connection::connect(envPath: $envPath);
	}

	#[Test]
	public function connect_with_mysql()
	{
		file_put_contents('.env.test', "DATABASE_CONNECTION=mysql\nDATABASE_HOST=127.0.0.1\nDATABASE_NAME=test\nDATABASE_USER=root\nDATABASE_PASSWORD=root\nDATABASE_PORT=3306");
		$envPath = RootFinder::findRootFolder(__DIR__) . '/.env.test';

		$connection = Connection::connect(envPath: $envPath);

		$this->assertInstanceOf(PDO::class, $connection);
	}

	#[Test]
	public function exception_Is_Thrown_When_Mysql_Connection_Fail()
	{
		file_put_contents('.env.test', "DATABASE_CONNECTION=mysql\nDATABASE_HOST=127.0.0.1\nDATABASE_NAME=dasdsadasasd\nDATABASE_USER=root\nDATABASE_PASSWORD=root\nDATABASE_PORT=3306");
		$envPath = RootFinder::findRootFolder(__DIR__) . '/.env.test';

		$this->expectException(Exception::class);
		$this->expectExceptionMessage("Failed to connect to database: SQLSTATE[HY000] [1049] Unknown database 'dasdsadasasd'");

		Connection::connect(envPath: $envPath);
	}

	#[Test]
	public function connect_with_pgsql()
	{
		file_put_contents('.env.test', "DATABASE_CONNECTION=pgsql\nDATABASE_HOST=127.0.0.1\nDATABASE_NAME=test\nDATABASE_USER=root\nDATABASE_PASSWORD=root\nDATABASE_PORT=5432");
		$envPath = RootFinder::findRootFolder(__DIR__) . '/.env.test';

		$connection = Connection::connect(envPath: $envPath);

		$this->assertInstanceOf(PDO::class, $connection);
	}

	#[Test]
	public function exception_Is_Thrown_When_Pgsql_Connection_Fail()
	{
		file_put_contents('.env.test', "DATABASE_CONNECTION=pgsql\nDATABASE_HOST=127.0.0.1\nDATABASE_NAME=tesasdsaasdt\nDATABASE_USER=root\nDATABASE_PASSWORD=root\nDATABASE_PORT=5432");
		$envPath = RootFinder::findRootFolder(__DIR__) . '/.env.test';

		$this->expectException(Exception::class);
		$this->expectExceptionMessage('SQLSTATE[08006] [7] connection to server at "127.0.0.1", port 5432 failed: FATAL:  database "tesasdsaasdt" does not exist');

		Connection::connect(envPath: $envPath);
	}

	#[Test]
	public function exception_Is_Thrown_When_Connection_Type_Is_Not_Supported()
	{
		file_put_contents('.env.test', "DATABASE_CONNECTION=mongodb");
		$envPath = RootFinder::findRootFolder(__DIR__) . '/.env.test';

		$this->expectException(Exception::class);
		$this->expectExceptionMessage("Database connection type is not supported");

		Connection::connect(envPath: $envPath);
	}

	#[Test]
	public function exception_Is_Thrown_When_Database_Connection_Parameters_Are_Missing()
	{
		file_put_contents('.env.test', "DATABASE_CONNECTION=mysql");
		$envPath = RootFinder::findRootFolder(__DIR__) . '/.env.test';

		$this->expectException(Exception::class);
		$this->expectExceptionMessage("Database connection parameters are not set in the .env file");

		Connection::connect(envPath: $envPath);
	}
}
