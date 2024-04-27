<?php

declare(strict_types=1);

namespace Yui\Core\Database\Initializers;

use PDO;
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
        static::createDatabaseAndTable($conn, 'yui', static::getCreateTableQuery());
        static::createDatabaseAndTable($conn, 'test', static::getCreateTableQuery());
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

    protected static function createDatabaseAndTable(PDO $conn, string $dbName, string $createTableQuery)
    {
        $stmt = $conn->query("SELECT 1 FROM pg_database WHERE datname = '$dbName'");
        $databaseExists = $stmt->fetchColumn();

        if (!$databaseExists) {
            $conn->exec("CREATE DATABASE $dbName");
        }

        $conn->exec($createTableQuery);
    }
}
