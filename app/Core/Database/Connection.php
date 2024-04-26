<?php

declare(strict_types=1);

namespace Yui\Core\Database;

use PDO;
use PDOException;
use Yui\Helpers\Dotenv;

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
        try {
            if (!static::$pdo) {
                Dotenv::load();

                $driver = Dotenv::get('DATABASE_CONNECTION');
                $host = Dotenv::get('DATABASE_HOST');
                $dbname = Dotenv::get('DATABASE_NAME');
                $user = Dotenv::get('DATABASE_USER');
                $pass = Dotenv::get('DATABASE_PASSWORD');
                $port = Dotenv::get('DATABASE_PORT');

                if($driver === null){
                    throw new PDOException("Database connection type is not set in the .env file");
                }

                if ($driver === 'sqlite') {
                    if ($pathToSqlite === null) {
                        throw new PDOException("Path to SQLite database is not set");
                    }
                
                    if (!file_exists($pathToSqlite)) {
                        throw new PDOException("SQLite database not found");
                    }
                
                    static::$pdo = new PDO("sqlite:{$pathToSqlite}", null, null, [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
                    ]);
                
                    echo "Connected to SQLite database" . PHP_EOL;
                
                    return static::$pdo;
                } elseif ($driver === 'mysql' || $driver === 'pgsql') {
                    if ($host === null || $dbname === null || $user === null || $pass === null || $port === null) {
                        throw new PDOException("Database credentials are not set in the .env file");
                    }
                
                    $dsn = $driver === 'mysql' ? "mysql:host={$host};port={$port};dbname={$dbname}" : "pgsql:host={$host};port={$port};dbname={$dbname}";
                
                    static::$pdo = new PDO($dsn, $user, $pass, [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
                    ]);
                
                    echo "Connecting to the database using host: {$host} {$driver}" . PHP_EOL;
                
                    return static::$pdo;
                } else { //If the database connection type is not supported
                    throw new PDOException("Database connection type is not supported");
                }
            }

            return static::$pdo;
        } catch (PDOException $e) {
            echo "[ERROR IN CONNECTION.PHP]" . PHP_EOL;
            echo "Error: " . $e->getMessage() . PHP_EOL;
            return null;
        }
    }
}
