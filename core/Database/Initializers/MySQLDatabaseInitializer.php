<?php

declare(strict_types=1);

namespace Yui\Core\Database\Initializers;

use Yui\Core\Database\Initializers\DatabaseInitializer;

/**
 * Initializes MySQL database.
 */
class MySQLDatabaseInitializer extends DatabaseInitializer
{
    /**
     * Initialize the MySQL database.
     *
     * @param array $config Database connection configuration.
     * @return void
     */
    public static function initialize(array $config)
    {
        $conn = static::createConnection($config);
        static::createDatabaseAndTable($conn, 'yui', static::getCreateTableQuery());
        static::createDatabaseAndTable($conn, 'test', static::getCreateTableQuery());
    }

    /**
     * Get the driver type for the MySQL database connection.
     *
     * @return string Database driver type.
     */
    protected static function getDriver(): string
    {
        return 'mysql';
    }

    /**
     * Get the SQL query to create the users table in MySQL.
     *
     * @return string SQL query.
     */
    protected static function getCreateTableQuery(): string
    {
        return "CREATE TABLE IF NOT EXISTS users (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(30) NOT NULL,
            email VARCHAR(50) NOT NULL,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";
    }
}
