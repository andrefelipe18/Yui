<?php

declare(strict_types=1);

namespace Yui\Core\Database\Initializers;

use Yui\Core\Database\Initializers\DatabaseInitializer;
use Yui\Core\Database\Drivers\Sqlite;
use PDO;

class SqliteDatabaseInitializer extends DatabaseInitializer
{
    /**
     * Initialize the database.
     *
     * @param array $config Database connection configuration.
     * @return void
     */
    public static function initialize(string $pathToSqlite): void
    {
        /** @var PDO */
        $conn = Sqlite::connect($pathToSqlite);
        static::createDatabaseAndTable($conn, 'yui', static::getCreateTableQuery());
    }


    /**
     * Get the driver type for the MySQL database connection.
     *
     * @return string Database driver type.
     */
    protected static function getDriver(): string
    {
        return 'sqlite';
    }

    /**
     * Get the SQL query to create the users table in MySQL.
     *
     * @return string SQL query.
     */
    protected static function getCreateTableQuery(): string
    {
        return "CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name VARCHAR(30) NOT NULL,
            email VARCHAR(50) NOT NULL,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
    }

    protected static function createDatabaseAndTable(PDO $conn, string $dbName, string $createTableQuery)
    {
        $conn->exec($createTableQuery);
    }
}
