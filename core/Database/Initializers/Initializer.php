<?php

declare(strict_types=1);

namespace Yui\Core\Database\Initializers;

use PDO;

abstract class Initializer
{
    /**
     * Run the initializer.
     *
     * @param array<string, string> $config
     */
    abstract public function run(array $config): void;

    /**
     * Create a new database.
     *
     * @param PDO $conn
     * @param string $dbName
     */
    abstract protected static function createDatabase(PDO $conn, string $dbName): void;

    /**
     * Create a new connection.
     *
     * @param array<string, string> $config
     * @param string|null $dbName
     * @return PDO
     */
    abstract protected function createConnection(array $config, ?string $dbName = ''): PDO;
}
