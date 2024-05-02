<?php

declare(strict_types=1);

namespace Yui\Core\Database\Builders;

class WhereBuilder
{
    protected string $whereSql = '';
    protected array $whereParams = [];

    public function getQuery()
    {
        return $this->whereSql;
    }

    public function getParams()
    {
        return $this->whereParams;
    }

    public function where(string $column, string $operator, $value)
    {
        $this->checkWhereParams($column, $operator, $value);

        $this->whereSql = " WHERE {$column} {$operator} ?";
        $this->whereParams[] = $value;

        return $this;
    }

    public function andWhere(string $column, string $operator, mixed $value)
    {
        $this->checkWhereParams($column, $operator, $value);

        $this->whereSql .= " AND {$column} {$operator} ?";
        $this->whereParams[] = $value;

        return $this;
    }

    public function orWhere(string $column, string $operator, mixed $value)
    {
        $this->checkWhereParams($column, $operator, $value);

        $this->whereSql .= " OR {$column} {$operator} ?";
        $this->whereParams[] = $value;

        return $this;
    }

    private function checkWhereParams(string $column, string $operator, mixed $value)
    {
        if (empty($column)) {
            throw new \Exception('In where clause, column is required');
        }

        if (empty($operator)) {
            throw new \Exception('In where clause, operator is required');
        }

        //The value can be 0
        if ($value === null || $value === '') {
            throw new \Exception('In where clause, value is required');
        }
    }
}
