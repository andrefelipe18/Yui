<?php

declare(strict_types=1);

namespace Yui\Core\Database\Migrations;

use Yui\Core\Database\Connection;

/**
 * @package Yui\Core\Database\Migrations
 */
class Schema
{
    /**
     * Create a new table
     * 
     * @param string $table
     * @param callable $callback
     * @return void
     */
    public static function create(string $table, callable $callback): void
    {
        $blueprint = new Blueprint($table);
        $callback($blueprint);

        $columns = implode(', ', $blueprint->columns);
        $sql = "CREATE TABLE IF NOT EXISTS {$blueprint->table} ($columns)";

        self::executeQuery($sql);
    }

    /**
     * Update a table
     * 
     * @param string $table
     * @param callable $callback
     * @return void
     */
    public static function table(string $table, callable $callback): void
    {
        $blueprint = new Blueprint($table);
        $callback($blueprint);

        $sql = "ALTER TABLE {$blueprint->table}";

        foreach ($blueprint->columns as $column) {
            $sql .= " $column";
        }

        self::executeQuery($sql);
    }

    /**
     * Execute a raw SQL query
     * 
     * @param string $sql
     * @return void
     */
    public static function raw(string $sql): void
    {
        self::executeQuery($sql);
    }
    
    /**
     * Drop a table
     * 
     * @param string $table
     * @return void
     */
    public static function dropIfExists(string $table)
    {
        $sql = "DROP TABLE IF EXISTS $table";

        self::executeQuery($sql);
    }

    /**
     * Execute a query
     * 
     * @param string $sql
     * @return void
     */
    private static function executeQuery(string $sql): void
    {
        $conn = Connection::connect();
        $stmt = $conn->prepare($sql);

        if (!$stmt->execute()) {
            throw new \Exception('Failed to execute query: ' . $sql);
        }
    }
}
