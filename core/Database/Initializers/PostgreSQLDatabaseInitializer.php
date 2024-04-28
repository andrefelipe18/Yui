<?php

declare(strict_types=1);

namespace Yui\Core\Database\Initializers;

use PDO;
use Yui\Core\Database\Drivers\Pgsql;
use Yui\Core\Database\Initializers\DatabaseInitializer;

/**
 * Initializes PostgreSQL database.
 */
class PostgreSQLDatabaseInitializer extends DatabaseInitializer
{
    /**
     * Initialize the database.
     *
     * @param array $config Database connection configuration.
     * @return void
     */
    public static function initialize(array $config): void
    {
        $conn = static::createConnection($config, 'yui');

        static::createDatabase($conn, 'test');
        static::createTable($conn, 'test', static::getCreateTableQuery(), config: $config);

        static::createDatabase($conn, 'yui');
        static::createTable($conn, 'yui', static::getCreateTableQuery(), config: $config);

        $conn = null;
    }

    /**
     * Get the driver type for the PostgreSQL database connection.
     *
     * @return string Database driver type.
     */
    protected static function getDriver(): string
    {
        return 'pgsql';
    }

    /**
     * Get the SQL query to create the users table in PostgreSQL.
     *
     * @return string SQL query.
     */
    protected static function getCreateTableQuery(): string
    {
        return "CREATE TABLE IF NOT EXISTS users (
            id SERIAL PRIMARY KEY,
            name VARCHAR(30) NOT NULL,
            email VARCHAR(50) NOT NULL,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
    }

    /**
     * Create the database if it doesn't exist.
     *
     * @param PDO $conn PDO database connection.
     * @param string $dbName Database name.
     * @return void
     */
    protected static function createDatabase(PDO $conn, string $dbName)
    {
        $stmt = $conn->query("SELECT 1 FROM pg_database WHERE datname = '$dbName'");
        $databaseExists = $stmt->fetchColumn();

        if (!$databaseExists) {
            $conn->exec("CREATE DATABASE $dbName");
        }

        $conn = null;
    }

    /**
     * Create the users table if it doesn't exist.
     *
     * @param PDO $conn PDO database connection.
     * @param string $dbName Database name.
     * @param string $createTableQuery SQL query to create the table.
     * @return void
     */
    protected static function createTable(PDO $conn, string $dbName, string $createTableQuery, ?array $config = [])
    {
        $conn = Pgsql::connect($config['host'], $dbName, $config['user'], $config['pass'], $config['port']);

        $stmt = $conn->query("SELECT to_regclass('public.users')");
        $tableExists = $stmt->fetchColumn();

        if (!$tableExists) {
            $conn->exec($createTableQuery);
        }

        $conn = null;
    }
}
