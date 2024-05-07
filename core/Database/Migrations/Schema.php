<?php

namespace Yui\Core\Database\Migrations;

declare(strict_types=1);

class Schema
{
    public static function create(string $table, callable $callback)
    {
        $blueprint = new Blueprint($table);
        $callback($blueprint);

        $columns = implode(', ', $blueprint->columns);
        $sql = "CREATE TABLE IF NOT EXISTS {$blueprint->table} ($columns)";
    }

    public static function table(string $table, callable $callback)
    {
        $blueprint = new Blueprint($table);
        $callback($blueprint);

        // Gere e execute as consultas SQL para alterar a tabela...
    }

    public static function dropIfExists(string $table)
    {
        $sql = "DROP TABLE IF EXISTS $table";

        // Execute a consulta SQL...
    }
}
  