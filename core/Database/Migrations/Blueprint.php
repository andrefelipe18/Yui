<?php

declare(strict_types=1);

namespace Yui\Core\Database\Migrations;

use Yui\Core\Database\Migrations\TimestampsStrategy\MySQLTimestampsStrategy;
use Yui\Core\Database\Migrations\TimestampsStrategy\PgsqlTimestampsStrategy;
use Yui\Core\Database\Migrations\TimestampsStrategy\SqliteTimestampsStrategy;
use Yui\Core\Database\Migrations\TimestampsStrategy\TimestampsStrategyInterface;
use Yui\Core\Helpers\Dotenv;

/**
 * This class represents a blueprint for creating a table
 * @package Yui\Core\Database\Migrations
 */
class Blueprint
{
    public string $table;
    /** @var array<string> */
    public array $columns = [];
    private TimestampsStrategyInterface $timestampsStrategy;

    public function __construct(string $table)
    {
        $this->table = $table;
        $this->timestampsStrategy = $this->getTimestampsStrategy();
    }

    /**
     * Define a column passing the column SQL
     *
     * @param string $sql
     * @return void
     */
    public function column(string $sql): void
    {
        $this->columns[] = $sql;
    }

    /**
     * Define or updating a column using raw SQL
     *
     * @param string $sql
     * @return void
     */
    public function raw(string $sql): void
    {
        $this->columns[] = $sql;
    }

    /**
     * Define a foreign key
     *
     * @param string $column
     * @param string $table
     * @param string $references
     * @return void
     */
    public function foreign(string $column, string $table, string $references): void
    {
        $this->columns[] = "FOREIGN KEY ($column) REFERENCES $table($references)";
    }

    /**
     * Define timestamps columns
     *
     * @return void
     */
    public function timestamps(): void
    {
        $this->columns[] = $this->timestampsStrategy->getQueryCreatedAtColumn();
        $this->columns[] = $this->timestampsStrategy->getQueryUpdatedAtColumn();
    }

    /**
     * Get the timestamps strategy based on the database driver
     * @return TimestampsStrategyInterface
     */
    private function getTimestampsStrategy(): TimestampsStrategyInterface
    {
        $driver = Dotenv::get('DATABASE_CONNECTION');

        switch ($driver) {
            case 'mysql':
                return new MySQLTimestampsStrategy();
            case 'pgsql':
                return new PgsqlTimestampsStrategy();
            case 'sqlite':
                return new SqliteTimestampsStrategy();
            default:
                throw new \Exception('Unsupported database driver');
        }
    }
}
