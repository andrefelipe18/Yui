<?php

declare(strict_types=1);

namespace Yui\Core\Database;

use Exception;
use PDO;
use PDOException;
use Yui\Core\Helpers\Dotenv;
use Yui\Core\Database\Drivers\Sqlite;
use Yui\Core\Database\Drivers\Pgsql;
use Yui\Core\Database\Drivers\Mysql;

/**
 * This class is responsible for connecting to the database using PDO
 * Use a singleton pattern to ensure that only one connection is made
 * @package Yui\Database\Connection
 */
class Connection
{
    /**
     * @var PDO|null
     */
    private static ?PDO $pdo = null;

    /**
     * Connect to the database
     * @param string|null $pathToSqlite
     * @param string|null $envPath
     * @param int|null $timeout
     * @return PDO|null
     */
    public static function connect(?string $pathToSqlite = null, ?string $envPath = '', ?int $timeout = 30): PDO|null
    {
        if (self::$pdo !== null) {
            return self::$pdo;
        }

        self::loadEnv($envPath);

        /** @var string */
        $driver = self::validateDriver();

        if ($driver === 'sqlite') {
            self::$pdo = self::connectSqlite($pathToSqlite);
        } else {
            self::$pdo = self::connectMysqlOrPgsql($driver, $timeout ?? 30);
        }

        return self::$pdo;
    }

    /**
     * Connect to MySQL or PostgreSQL
     *
     * @param string $driver
     * @param integer $timeout
     * @return PDO
     */
    public static function connectMysqlOrPgsql(string $driver, int $timeout): PDO
    {
        $host = Dotenv::get('DATABASE_HOST');
        $dbname = Dotenv::get('DATABASE_NAME');
        $user = Dotenv::get('DATABASE_USER');
        $pass = Dotenv::get('DATABASE_PASSWORD');
        $port = Dotenv::get('DATABASE_PORT');

        if ($host === null || $dbname === null || $user === null || $pass === null || $port === null) {
            throw new Exception("Database connection parameters are not set in the .env file");
        }

        try {
            /**
             * @var PDO|PDOException $tempPDO
             */
            $tempPDO = null;

            switch ($driver) {
                case 'mysql':
                    $tempPDO = Mysql::connect($host, $dbname, $user, $pass, $port, $timeout);
                    break;
                case 'pgsql':
                    $tempPDO = Pgsql::connect($host, $dbname, $user, $pass, $port, $timeout);
                    break;
            }

            if ($tempPDO instanceof PDO) {
                self::$pdo = $tempPDO;
            } else {
                throw new Exception("Failed to connect to database: " . $tempPDO->getMessage());
            }
        } catch (PDOException $e) {
            throw new Exception("Failed to connect to database: " . $e->getMessage());
        }

        return self::$pdo;
    }

    /**
     * Load the .env file
     *
     * @param string|null $envPath
     * @return void
     */
    private static function loadEnv(?string $envPath = ''): void
    {
        if ($envPath !== '') {
            Dotenv::load($envPath);
        } else {
            Dotenv::load();
        }
    }

    private static function validateDriver(): string
    {
        $driver = Dotenv::get('DATABASE_CONNECTION');

        if ($driver === null) {
            throw new Exception("Database connection type is not set in the .env file");
        }

        if (!in_array($driver, ['sqlite', 'mysql', 'pgsql'])) {
            throw new Exception("Database connection type is not supported");
        }

        return $driver;
    }

    /**
     * Connect to the database
     * @param string|null $pathToSqlite
     */
    private static function connectSqlite(?string $pathToSqlite = null): PDO
    {
        if ($pathToSqlite === null) {
            throw new Exception("Path to SQLite file is not set");
        }

        $conn = Sqlite::connect($pathToSqlite);

        if ($conn instanceof PDOException) {
            throw new Exception("Failed to connect to database: " . $conn->getMessage());
        }

        return $conn;
    }

    /**
     * Ends the connection with the database
     * @return void
     */
    public static function disconnect(): void
    {
        self::$pdo = null;
    }
}
