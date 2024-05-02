<?php

declare(strict_types=1);

namespace Yui\Core\Database;

use PDO;

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
}