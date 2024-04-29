<?php

declare(strict_types=1);

namespace Yui\Core\Database\Initializers;

use Exception;
use PDO;
use Yui\Core\Database\Drivers\Mysql;
use Yui\Core\Database\Initializers\Initializer;

/**
 * Initializes MySQL database.
 */
class MySQLDatabaseInitializer extends Initializer
{
    /**
     * Run the initializer.
     *
     * @param array<string, string> $config
     */
    public function run(array $config): void
    {
        $conn = $this->createConnection($config);
        self::createDatabase($conn, 'test');
        self::createDatabase($conn, 'yui');
    }

    /**
     * Create a new database.
     *
     * @param PDO $conn
     * @param string $dbName
     */
    protected static function createDatabase(PDO $conn, string $dbName): void
    {
        $conn->exec("CREATE DATABASE IF NOT EXISTS {$dbName}");
    }

    /**
     * Create a new connection.
     *
     * @param array<string, string> $config
     * @param string|null $dbName
     * @return PDO
     */
    protected function createConnection(array $config, ?string $dbName = ''): PDO
    {
        return new PDO("mysql:host={$config['host']};port={$config['port']}", $config['user'], $config['pass']);
    }
}
