<?php

declare(strict_types=1);

namespace Yui\Core\Database\Builders;

class SelectBuilder
{
    protected array $columns = [];

    public function getQuery()
    {
        return implode(', ', $this->columns);
    }

    public function getParams()
    {
        return [];
    }

    public function select(...$columns)
    {
        foreach ($columns as $column) {
            $this->validateColumn($column, $columns);

            if ($column === '*') {
                $this->columns = ['*'];
                break;
            }

            if (!in_array($column, $this->columns)) {
                $this->columns[] = $column;
            }
        }

        return $this;
    }

    private function validateColumn($column, $columns)
    {
        if (empty($column)) {
            throw new \Exception('Column name is required');
        }
        if ($column === '*' && count($columns) > 1) {
            throw new \Exception('You cannot select all columns with other columns');
        }
    }
}