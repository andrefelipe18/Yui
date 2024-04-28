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
 * @property private static $pdo
 * @method static connect()
 */
abstract class Connection
{
    private static PDO|null $pdo = null;

    /**
     * @return PDO
     */
    public static function connect(?string $pathToSqlite = null, ?string $envPath = '', int $timeout = 30): PDO|null
    {
        if (static::$pdo) {
            return static::$pdo;
        }

        if ($envPath !== '') {
            Dotenv::load($envPath);
        } else {
            Dotenv::load();
        }

        $driver = Dotenv::get('DATABASE_CONNECTION');

        if ($driver === null) {
            throw new Exception("Database connection type is not set in the .env file");
        }

        if (!in_array($driver, ['sqlite', 'mysql', 'pgsql'])) {
            throw new Exception("Database connection type is not supported");
        }

        if ($driver === 'sqlite' && $pathToSqlite === null) {
            throw new Exception("Path to SQLite file is not set");
        }

        if ($driver === 'sqlite') {
            static::$pdo = Sqlite::connect($pathToSqlite);
            return static::$pdo;
        }

        $host = Dotenv::get('DATABASE_HOST');
        $dbname = Dotenv::get('DATABASE_NAME');
        $user = Dotenv::get('DATABASE_USER');
        $pass = Dotenv::get('DATABASE_PASSWORD');
        $port = Dotenv::get('DATABASE_PORT');

        if ($host === null || $dbname === null || $user === null || $pass === null || $port === null) {
            throw new Exception("Database connection parameters are not set in the .env file");
        }

        try {
            switch ($driver) {
                case 'mysql':
                    $tempPDO = Mysql::connect($host, $dbname, $user, $pass, $port, $timeout);
                    break;
                case 'pgsql':
                    $tempPDO = Pgsql::connect($host, $dbname, $user, $pass, $port, $timeout);
                    break;
            }

            if($tempPDO instanceof PDO) {
                static::$pdo = $tempPDO;
            } else {
                throw new Exception("Failed to connect to database: " . $tempPDO->getMessage());
            }
        } catch (PDOException $e) {
            throw new Exception("Failed to connect to database: " . $e->getMessage());
        }

        return static::$pdo;
    }

    /**
     * Ends the connection with the database
     *
     * @return void
     */
    public static function disconnect(): void
    {

        static::$pdo = null;
    }
}
