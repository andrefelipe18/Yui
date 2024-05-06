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
    public static function table(string $table): QueryBuilder
    {
        return new QueryBuilder($table);
    }

    public static function raw(string $sql, array $params = []): array
    {
        return RawBuilder::raw($sql, $params);
    }
}
