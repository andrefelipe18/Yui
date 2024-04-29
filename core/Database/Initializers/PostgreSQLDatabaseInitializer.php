<?php

declare(strict_types=1);

namespace Yui\Core\Database\Initializers;

use PDO;

/**
 * Initializes PostgreSQL database.
 */
class PostgreSQLDatabaseInitializer extends Initializer
{
    /**
     * Run the initializer.
     *
     * @param array<string, string> $config
     */
    public function run(array $config): void
    {
        $conn = $this->createConnection($config, 'yui');
        self::createDatabase($conn, 'yui');
        self::createDatabase($conn, 'test');
    }

    /**
     * Create a new database.
     *
     * @param PDO $conn
     * @param string $dbName
     */
    protected static function createDatabase(PDO $conn, string $dbName): void
    {
        $stmt = $conn->query("SELECT 1 FROM pg_database WHERE datname = '$dbName'");

        if($stmt === false) {
            return;
        }

        $databaseExists = $stmt->fetchColumn();

        if (!$databaseExists) {
            $conn->exec("CREATE DATABASE $dbName");
        }
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
        return new PDO("pgsql:host={$config['host']};port={$config['port']};dbname={$dbName}", $config['user'], $config['pass']);
    }
}
