<?php

declare(strict_types=1);

namespace Yui\Core\Database;

use Exception;
use PDO;
use Yui\Core\Helpers\Dotenv;
use Yui\Core\Database\Initializers\MySQLDatabaseInitializer;
use Yui\Core\Database\Initializers\PostgreSQLDatabaseInitializer;
use Yui\Core\Exceptions\Database\DatabaseInitializerException;

/**
 * Base class for database initializers.
 *
 * Dependency Injection: Instead of creating the PDO connection directly in child classes,
 * you could pass it as a dependency. This would make your code more testable and flexible.
 */
class DatabaseInitializer
{
    private static string $driver = '';

    /**
     * Initialize the database.
     * @param array<string, string>|null $config Database connection configuration.
     * @param string|null $envPath Path to the .env file.
     */
    public static function init(array $config = null, ?string $envPath = null): void
    {
        self::loadEnv($envPath);

        if ($config === null) {
            self::setDriver();
            self::checkDriver();
            $config = self::getConnectionConfig();
        }

        $initializer = self::createInitializer();
        $initializer->run($config);
    }

    /**
     * Create the database initializer.
     * @return MySQLDatabaseInitializer|PostgreSQLDatabaseInitializer
     */
    private static function createInitializer(): MySQLDatabaseInitializer|PostgreSQLDatabaseInitializer
    {
        if (self::$driver === 'mysql') {
            $initializer = new MySQLDatabaseInitializer();
        } else {
            $initializer = new PostgreSQLDatabaseInitializer();
        }

        return $initializer;
    }

    /**
     * Load the environment variables from the .env file.
     * @param string|null $envPath Path to the .env file.
     */
    private static function loadEnv(?string $envPath): void
    {
        if ($envPath !== null) {
            Dotenv::load($envPath);
        } else {
            Dotenv::load();
        }
    }

    /**
     * Set the database driver.
     * @throws DatabaseInitializerException If the database driver is not set or is not supported.
     */
    private static function setDriver(): void
    {
        $driver = Dotenv::get('DATABASE_CONNECTION');
        if($driver === null) {
            throw new DatabaseInitializerException("Database connection type is not set in the .env file");
        }

        self::$driver = $driver;
    }

    /**
     * Check if the database driver is set and supported.
     * @throws DatabaseInitializerException If the database driver is not set or is not supported.
     * @return void
     */
    private static function checkDriver(): void
    {
        if (self::$driver == '' || self::$driver == null) {
            throw new DatabaseInitializerException("Database connection type is not set in the .env file");
        }

        if (!in_array(self::$driver, ['sqlite', 'mysql', 'pgsql'])) {
            throw new DatabaseInitializerException("Database connection type is not supported");
        }
    }

    /**
     * Return database array config
     * @return array<string, string>
     */
    private static function getConnectionConfig(): array
    {
        $config = [
            'host' => Dotenv::get('DATABASE_HOST'),
            'user' => Dotenv::get('DATABASE_USER'),
            'pass' => Dotenv::get('DATABASE_PASSWORD'),
            'port' => Dotenv::get('DATABASE_PORT')
        ];

        if($config['host'] === null || $config['user'] === null || $config['pass'] === null || $config['port'] === null) {
            throw new DatabaseInitializerException("Database connection parameters are not set in the .env file");
        } else {
            return $config;
        }
    }
}
