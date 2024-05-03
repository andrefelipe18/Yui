<?php

declare(strict_types=1);

namespace Yui\Core\Database\Builders;

use PDO;
use Yui\Core\Database\Connection;
use Yui\Core\Database\Builders\Builder;

/**
 * Class responsible for building SQL delete queries.
 *
 * @package Yui\Core\Database\Builders
 */
class DeleteBuilder extends Builder
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
     * Sets the where parameters.
     *
     * @param array<int|string, mixed> $whereParams
     * @return void
     */
    public function setWhereParams(array $whereParams): void
    {
        $this->whereParams = $whereParams;
    }

    /**
     * Deletes the rows that match the where clause.
     *
     * @return DeleteBuilder
     */
    public function delete(): DeleteBuilder
    {
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

        $this->executeDelete();
    }

    private function executeDelete(): ?int
    {
        if (empty($this->whereBuilder->getQuery())) {
            return null;
        }

        $this->setWhereParams($this->whereBuilder->getParams());

        $query = $this->createQuery();

        $stmt = $this->conn->prepare($query);

        $stmt->execute($this->whereParams);

        return $stmt->rowCount();
    }

    private function createQuery(): string
    {
        $whereSql = $this->whereBuilder->getQuery();

        $query = "DELETE FROM {$this->table} {$whereSql}";

        return $query;
    }
}
