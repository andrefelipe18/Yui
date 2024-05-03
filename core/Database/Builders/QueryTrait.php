<?php

declare(strict_types=1);

namespace Yui\Core\Database\Builders;

/**
 * Trait responsible for building SQL queries.
 * 
 * @package Yui\Core\Database\Builders
 */
trait QueryTrait
{
    protected string $sql = '';
    protected array $params = [];

    /**
     * Returns the query.
     * 
     * @return string
     */
    public function getQuery(): string
    {
        return $this->sql;
    }

    /**
     * Returns the query parameters.
     * 
     * @return array<int|string, mixed>
     */
    public function getParams(): array
    {
        return $this->params;
    }
}
