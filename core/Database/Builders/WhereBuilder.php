<?php

declare(strict_types=1);

namespace Yui\Core\Database\Builders;

use Yui\Core\Database\Builders\Builder;
use Yui\Core\Database\Builders\QueryTrait;

class WhereBuilder extends Builder
{
    use QueryTrait;

    protected string $sql = '';
    /** @var array<int|string, mixed> */
    protected array $params = [];

    /**
     * Builds the where clause.
     *
     * @param string $column
     * @param string $operator
     * @param mixed $value
     * @return WhereBuilder
     */
    public function where(string $column, string $operator, mixed $value): WhereBuilder
    {
        $this->checkparams($column, $operator, $value);

        $this->sql = " WHERE {$column} {$operator} ?";
        $this->params[] = $value;

        return $this;
    }

    /**
     * Builds the and where clause.
     *
     * @param string $column
     * @param string $operator
     * @param mixed $value
     * @return WhereBuilder
     */
    public function andWhere(string $column, string $operator, mixed $value): WhereBuilder
    {
        $this->checkparams($column, $operator, $value);

        $this->sql .= " AND {$column} {$operator} ?";
        $this->params[] = $value;

        return $this;
    }

    /**
     * Builds the or where clause.
     *
     * @param string $column
     * @param string $operator
     * @param mixed $value
     * @return WhereBuilder
     */
    public function orWhere(string $column, string $operator, mixed $value): WhereBuilder
    {
        $this->checkparams($column, $operator, $value);

        $this->sql .= " OR {$column} {$operator} ?";
        $this->params[] = $value;

        return $this;
    }

    /**
     * Checks if the where parameters are valid.
     *
     * @param string $column
     * @param string $operator
     * @param mixed $value
     * @return void
     */
    private function checkparams(string $column, string $operator, mixed $value): void
    {
        $this->validateNotEmpty($column, 'In where clause, column is required');
        $this->validateNotEmpty($operator, 'In where clause, operator is required');

        //The value can be 0
        if ($value === null || $value === '') {
            throw new \Exception('In where clause, value is required');
        }
    }
}
