<?php

declare(strict_types=1);

namespace Yui\Core\Database;

use PDO;
use PDOException;
use Yui\Core\Database\Builders\RawBuilder;

/**
 * Class responsible for building SQL queries.
 * @package Yui\Core\Database
 */
class DB
{
    /**
     * Create a new query builder instance.
     * @param string $table
     * @param PDO|null $testingPdo
     * @return QueryBuilder
     */
    public static function table(string $table, ?PDO $testingPdo = null): QueryBuilder
    {
        return new QueryBuilder($table, $testingPdo);
    }

    /**
     * Execute a raw SQL query.
     * @param string $sql
     * @param array<mixed, mixed> $params
     * @param PDO|null $testingPdo
     * @return array<mixed, mixed>
     */
    public static function raw(string $sql, array $params = [], ?PDO $testingPdo = null): array
    {
        return RawBuilder::raw($sql, $params, $testingPdo);
    }
}
