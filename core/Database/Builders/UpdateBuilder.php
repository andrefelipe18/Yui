<?php

declare(strict_types=1);

namespace Yui\Core\Database\Builders;

use PDO;
use Yui\Core\Database\Connection;

/**
 * Class responsible for building SQL update queries.
 * 
 * @package Yui\Core\Database\Builders
 */
class UpdateBuilder extends Builder
{
    protected string $table = '';
    /** @var array<string, mixed> */
    protected array $values = [];
    /** @var array<int|string, mixed> */
    protected array $whereParams = [];
    protected WhereBuilder $whereBuilder;
    protected PDO $conn;

    /**
     * InsertBuilder class constructor.
     *
     * @param string $table Name of the table where the insertion will be performed.
     */
    public function __construct(string $table)
    {
        $this->table = $table;
        $this->conn = Connection::connect();
        $this->whereBuilder = new WhereBuilder();
    }

    /**
     * Set the where parameters.
     *
     * @param array<int|string, mixed> $whereParams
     * @return void
     */
    private function setWhereParams(array $whereParams): void
    {
        $this->whereParams = $whereParams;
    }

    /**
     * Sets the values to be updated.
     *
     * @param array<string, mixed> $values The values to be updated.
     * @return $this
     */
    private function update(array $values): UpdateBuilder
    {
        $this->validateValues($values);

        $this->values = $values;

        return $this;
    }

    /**
     * Sets the where clause for the update query.
     *
     * @param string $column The column to be used in the where clause.
     * @param string $operator The operator to be used in the where clause.
     * @param mixed $value The value to be used in the where clause.
     * @return void
     */
    public function where(string $column, string $operator, $value): void
    {
        $this->whereBuilder->where($column, $operator, $value);

        $this->executeUpdate();
    }

    /**
     * Executes the update query.
     *
     * @return int|null The number of rows affected by the update query.
     */
    private function executeUpdate(): ?int
    {
        if (empty($this->whereBuilder->getQuery())) {
            return null;
        }

        $this->setWhereParams($this->whereBuilder->getParams());

        $this->validateValues($this->values);
        $query = $this->createQuery($this->values);

        $stmt = $this->conn->prepare($query);
        $stmt->execute(array_merge(array_values($this->values), $this->whereParams));

        return $stmt->rowCount();
    }

    /**
     * Creates the update query.
     *
     * @param array<string, mixed> $values The values to be updated.
     * @return string The update query.
     */
    private function createQuery(array $values): string
    {
        $set = [];

        foreach ($values as $column => $value) {
            $set[] = "{$column} = ?";
        }

        $set = implode(', ', $set);
        $whereSql = $this->whereBuilder->getQuery();

        $query = "UPDATE {$this->table} SET {$set} {$whereSql}";

        return $query;
    }

    /**
     * Validates the values to be updated.
     *
     * @param array<string, mixed> $values The values to be updated.
     * @return void
     */
    private function validateValues(array $values): void
    {
        $this->validateNotEmpty($values, 'In update clause, values are required');

        foreach ($values as $key => $value) {
            if (!is_string($key)) {
                throw new \Exception('In update clause, associative array is required');
            }
        }
    }
}
