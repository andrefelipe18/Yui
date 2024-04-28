<?php

declare(strict_types=1);

namespace Yui\Core\Database\Initializers;

use Exception;
use PDO;
use Yui\Core\Helpers\Dotenv;

/**
 * Base class for database initializers.
 * 
 * Dependency Injection: Instead of creating the PDO connection directly in child classes,
 * you could pass it as a dependency. This would make your code more testable and flexible.
 */
abstract class DatabaseInitializer
{
    /**
     * Initialize the database.
     * 
     * @return void
     */
    public static function init(array $config = null, ?string $pathToSqlite = null)
    {
        $driver = '';
        if ($config === null) {
            Dotenv::load();
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
                // static::$pdo = Sqlite::connect($pathToSqlite);
                // return static::$pdo;

                $initializer = new SqliteDatabaseInitializer();

                $initializer->initialize($pathToSqlite);
            }

            $host = Dotenv::get('DATABASE_HOST');
            $user = Dotenv::get('DATABASE_USER');
            $pass = Dotenv::get('DATABASE_PASSWORD');
            $port = Dotenv::get('DATABASE_PORT');

            $config = [
                'host' => $host,
                'user' => $user,
                'pass' => $pass,
                'port' => $port
            ];
        }

        switch ($driver) {
            case 'mysql':
                $initializer = new MySQLDatabaseInitializer();
                break;
            case 'pgsql':
                $initializer = new PostgreSQLDatabaseInitializer();
                break;
        }

        if (isset($initializer)) {
            $initializer->initialize($config);
        }
    }

    /**
     * Creates a PDO connection based on configuration.
     * 
     * @param array $config Database connection configuration.
     * @return PDO PDO database connection.
     */
    protected static function createConnection(array $config, ?string $dbName = null): PDO
    {
        $driver = static::getDriver();
        $host = $config['host'];
        $user = $config['user'];
        $pass = $config['pass'];
        $port = $config['port'];

        switch ($driver) {
            case 'mysql':
                return new PDO("mysql:host={$host};port={$port}", $user, $pass);
            case 'pgsql':
                return new PDO("pgsql:host={$host};port={$port};dbname={$dbName}", $user, $pass);
            default:
                throw new Exception("Unsupported database driver: $driver");
        }
    }

    /**
     * Creates the database and table if they don't exist.
     * 
     * @param PDO $conn PDO database connection.
     * @param string $dbName Database name.
     * @param string $createTableQuery SQL query to create the table.
     * @return void
     */
    protected static function createDatabaseAndTable(PDO $conn, string $dbName, string $createTableQuery)
    {
        $conn->exec("CREATE DATABASE IF NOT EXISTS {$dbName}");
        $conn->exec("USE {$dbName}");
        $conn->exec($createTableQuery);
    }

    /**
     * Get the driver type for the database connection.
     * 
     * @return string Database driver type.
     */
    abstract protected static function getDriver(): string;

    /**
     * Get the SQL query to create the database table.
     * 
     * @return string SQL query.
     */
    abstract protected static function getCreateTableQuery(): string;
}
