<?php

declare(strict_types=1);

namespace Tests\Yui\Core\Database\Drivers;

use Yui\Core\Database\Drivers\Pgsql;
use PHPUnit\Framework\Attributes\Test;
use PDO;
use PDOException;
use PHPUnit\Framework\TestCase;


class PgsqlTest extends TestCase
{
    #[Test]
    public function successful_connection()
    {
        $host = '127.0.0.1';
        $dbname = 'test';
        $user = 'root';
        $pass = 'root';
        $port = '5432';
        $connection = Pgsql::connect($host, $dbname, $user, $pass, $port);

        $this->assertInstanceOf(PDO::class, $connection);
    }

    #[Test]
    public function connection_failure()
    {
        $host = '127.0.0.1';
        $dbname = 'wrong_database_name';
        $user = 'root';
        $pass = 'root';
        $port = '5432';

        $connection = Pgsql::connect($host, $dbname, $user, $pass, $port);

        $this->assertInstanceOf(PDOException::class, $connection);
        $this->assertMatchesRegularExpression("/SQLSTATE\[08006\] \[7\] connection to server at \"(.*)\", port 5432 failed: FATAL:  database \"wrong_database_name\" does not exist/", $connection->getMessage());
    }

    #[Test]
    public function authentication_failure()
    {
        $host = '127.0.0.1';
        $dbname = 'test';
        $user = 'root';
        $pass = 'wrong_password';
        $port = '5432';

        $connection = Pgsql::connect($host, $dbname, $user, $pass, $port);

        $this->assertInstanceOf(PDOException::class, $connection);
        $this->assertMatchesRegularExpression("/SQLSTATE\[08006\] \[7\] connection to server at \"(.*)\", port 5432 failed: FATAL:  password authentication failed for user \"root\"/", $connection->getMessage());
    }

    #[Test]
    public function invalid_port()
    {
        $host = '127.0.0.1';
        $dbname = 'test';
        $user = 'root';
        $pass = 'root';
        $port = '5433';

        $connection = Pgsql::connect($host, $dbname, $user, $pass, $port);

        $this->assertInstanceOf(PDOException::class, $connection);
        $this->assertMatchesRegularExpression("/SQLSTATE\[08006\] \[7\] connection to server at \"(.*)\", port 5433/", $connection->getMessage());
    }

    #[Test]
    public function database_failure()
    {
        $host = '1';
        $dbname = 'wrong_database';
        $user = 'root';
        $pass = 'wrong_password';
        $port = '5432';

        $connection = Pgsql::connect($host, $dbname, $user, $pass, $port, 1);

        $this->assertInstanceOf(PDOException::class, $connection);
        $this->assertMatchesRegularExpression("/SQLSTATE\[08006\] \[7\] connection to server at \"1\" \(0.0.0.1\), port 5432 failed: timeout expired/", $connection->getMessage());
    }
}
