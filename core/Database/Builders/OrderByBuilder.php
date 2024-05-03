<?php

declare(strict_types=1);

namespace Yui\Core\Database\Builders;

use Yui\Core\Database\Builders\Builder;
use Yui\Core\Database\Builders\QueryTrait;

/**
 * Class responsible for building SQL order by queries.
 * 
 * @package Yui\Core\Database\Builders
 */
class OrderByBuilder extends Builder
{
    use QueryTrait;

    protected string $sql = '';
    /** @var array<string, mixed> */
    protected array $params = [];

    /**
     * Orders the results by the specified column.
     * 
     * @param string $column The column to order by.
     * @param string $order The order to be used.
     * @return OrderByBuilder
     */
    public function orderBy(string $column, string $order = 'ASC'): OrderByBuilder
    {
        $this->checkOrderByParams($column, $order);
        $this->sql .= " ORDER BY {$column} {$order}";

        return $this;
    }

    /**
     * Checks if the order by parameters are valid.
     *
     * @param string $column The column to order by.
     * @param string $order The order to be used.
     * @return void
     */
    private function checkOrderByParams(string $column, string $order): void
    {
        $this->validateNotEmpty($column, 'In order by clause, column is required');
        $this->validateNotEmpty($order, 'In order by clause, order is required');

        if (!in_array(strtoupper($order), ['ASC', 'DESC'])) {
            throw new \Exception('In order by clause, order must be ASC or DESC');
        }
    }
}
