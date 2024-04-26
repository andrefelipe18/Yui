<?php

declare(strict_types=1);

namespace Tests\Yui\Core\Database\Drivers;

use Yui\Core\Database\Drivers\Mysql;
use PHPUnit\Framework\Attributes\Test;
use PDO;
use PDOException;

use PHPUnit\Framework\TestCase;
use Yui\Helpers\Dotenv;
use Yui\Helpers\RootFinder;

/**
 * Class MysqlTest
 * @package Tests\Yui\Core\Database\Drivers
 */
class MysqlTest extends TestCase
{

	#[Test]
	public function successful_connection()
	{
		$host = '127.0.0.1';
		$dbname = 'test';
		$user = 'root';
		$pass = 'root';
		$port = '3306';
		$connection = Mysql::connect($host, $dbname, $user, $pass, $port);

		$this->assertInstanceOf(PDO::class, $connection);
	}

	#[Test]
	public function connection_failure()
	{
		$host = '127.0.0.1';
		$dbname = 'wrong_database_name';
		$user = 'root';
		$pass = 'root';
		$port = '3306';

		$connection = Mysql::connect($host, $dbname, $user, $pass, $port);

		$this->assertInstanceOf(PDOException::class, $connection);
		$this->assertMatchesRegularExpression("/SQLSTATE\[HY000\] \[1049\] Unknown database '(.*)'/", $connection->getMessage());
	}

	#[Test]
	public function authentication_failure()
	{
		$host = '127.0.0.1';
		$dbname = 'test';
		$user = 'root';
		$pass = 'wrong_password';
		$port = '3306';

		$connection = Mysql::connect($host, $dbname, $user, $pass, $port);

		$this->assertInstanceOf(PDOException::class, $connection);
		$this->assertMatchesRegularExpression("/SQLSTATE\[HY000\] \[1045\] Access denied for user '(.*)'@'(.*)' \(using password: YES\)/", $connection->getMessage());
	}

	#[Test]
	public function invalid_port()
	{
		$host = '127.0.0.1';
		$dbname = 'test';
		$user = 'root';
		$pass = 'root';
		$port = '3307';

		$connection = Mysql::connect($host, $dbname, $user, $pass, $port);

		$this->assertInstanceOf(PDOException::class, $connection);
		$this->assertMatchesRegularExpression("/SQLSTATE\[HY000\] \[2002\] Connection refused/", $connection->getMessage());
	}

	#[Test]
	public function database_failure()
	{
		$host = '1';
		$dbname = 'wrong_database';
		$user = 'root';
		$pass = 'wrong_password';
		$port = '3306';

		$connection = Mysql::connect($host, $dbname, $user, $pass, $port, 1);

		$this->assertInstanceOf(PDOException::class, $connection);
		$this->assertMatchesRegularExpression("/SQLSTATE\[HY000\] \[2002\] Connection timed out/", $connection->getMessage());
	}
}
