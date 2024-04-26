<?php

declare(strict_types=1);

namespace Yui\Core\Database;

use Exception;
use PDO;
use PDOException;
use Yui\Helpers\Dotenv;
use Yui\Core\Database\Drivers\{Sqlite, Pgsql, Mysql};

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
    public static function connect(string|null $pathToSqlite = null): PDO|null
    {
        if (static::$pdo) {
            return static::$pdo;
        }

        Dotenv::load();

        $driver = Dotenv::get('DATABASE_CONNECTION');
        $host = Dotenv::get('DATABASE_HOST');
        $dbname = Dotenv::get('DATABASE_NAME');
        $user = Dotenv::get('DATABASE_USER');
        $pass = Dotenv::get('DATABASE_PASSWORD');
        $port = Dotenv::get('DATABASE_PORT');

        if ($driver === null) {
            throw new Exception("Database connection type is not set in the .env file");
        }

        match ($driver) {
            'sqlite' => static::$pdo = Sqlite::connect($pathToSqlite),
            'mysql' => static::$pdo = Mysql::connect($host, $dbname, $user, $pass, $port),
            'pgsql' => static::$pdo = Pgsql::connect($host, $dbname, $user, $pass, $port),
            default => throw new PDOException("Database connection type is not supported")
        };

        return static::$pdo;
    }
}
