<?php

declare(strict_types=1);

namespace Yui\Core\Database\Builders;

use Yui\Core\Database\Builders\Builder;

/**
 * Class responsible for building SQL select queries.
 *
 * @package Yui\Core\Database\Builders
 */
class SelectBuilder extends Builder
{
    /** @var array<string> */
    protected array $columns = [];

    /**
     * Returns the query.
     *
     * @return string
     */
    public function getQuery(): string
    {
        return implode(', ', $this->columns);
    }

    /**
     * Selects the columns to be retrieved from the database.
     *
     * @param string ...$columns
     * @return SelectBuilder
     */
    public function select(...$columns): SelectBuilder
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

    /**
     * Validates the column.
     *
     * @param string $column
     * @param array<string> $columns
     * @return void
     */
    private function validateColumn($column, $columns): void
    {
        $this->validateNotEmpty($column, 'In select clause, column is required');
        if ($column === '*' && count($columns) > 1) {
            throw new \Exception('You cannot select all columns with other columns');
        }
    }
}
