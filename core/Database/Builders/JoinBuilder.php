<?php

declare(strict_types=1);

namespace Yui\Core\Database\Builders;

use Yui\Core\Database\Builders\Builder;
use Yui\Core\Database\Builders\QueryTrait;

/**
 * Class responsible for building SQL join queries.
 *
 * @package Yui\Core\Database\Builders
 */
class JoinBuilder extends Builder
{
    use QueryTrait;

    protected string $sql = '';
    /** @var array<int|string, mixed> */
    protected array $params = [];

    /**
     * Joins two tables.
     *
     * @param string $table The table to join.
     * @param string $column1 The column from the first table.
     * @param string $operator The operator to be used in the join clause.
     * @param string $column2 The column from the second table.
     * @return JoinBuilder
     */
    public function join(string $table, string $column1, string $operator, string $column2): JoinBuilder
    {
        $this->checkJoinParams($table, $column1, $operator, $column2);
        $this->sql .= " JOIN {$table} ON {$column1} {$operator} {$column2}";

        return $this;
    }

    /**
     * Joins two tables using the LEFT JOIN clause.
     *
     * @param string $table The table to join.
     * @param string $column1 The column from the first table.
     * @param string $operator The operator to be used in the join clause.
     * @param string $column2 The column from the second table.
     * @return JoinBuilder
     */
    public function leftJoin(string $table, string $column1, string $operator, string $column2): JoinBuilder
    {
        $this->checkJoinParams($table, $column1, $operator, $column2);
        $this->sql .= " LEFT JOIN {$table} ON {$column1} {$operator} {$column2}";

        return $this;
    }

    /**
     * Joins two tables using the RIGHT JOIN clause.
     *
     * @param string $table The table to join.
     * @param string $column1 The column from the first table.
     * @param string $operator The operator to be used in the join clause.
     * @param string $column2 The column from the second table.
     * @return JoinBuilder
     */
    public function rightJoin(string $table, string $column1, string $operator, string $column2): JoinBuilder
    {
        $this->checkJoinParams($table, $column1, $operator, $column2);
        $this->sql .= " RIGHT JOIN {$table} ON {$column1} {$operator} {$column2}";

        return $this;
    }

    /**
     * Checks if the join parameters are valid.
     *
     * @param string $table The table to join.
     * @param string $column1 The column from the first table.
     * @param string $operator The operator to be used in the join clause.
     * @param string $column2 The column from the second table.
     * @throws \Exception If any of the parameters is empty.
     */
    private function checkJoinParams(string $table, string $column1, string $operator, string $column2): void
    {
        $this->validateNotEmpty($table, 'In join clause, table is required');
        $this->validateNotEmpty($column1, 'In join clause, column1 is required');
        $this->validateNotEmpty($operator, 'In join clause, operator is required');
        $this->validateNotEmpty($column2, 'In join clause, column2 is required');
    }
}
