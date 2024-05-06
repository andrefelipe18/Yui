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
class LimitBuilder extends Builder
{
    use QueryTrait;

    protected string $sql = '';
    /** @var array<string, mixed> */
    protected array $params = [];

    /**
     * Limits the results by the specified limit.
     *
     * @param int $limit The limit to be used.
     * @return LimitBuilder
     */
    public function limit(int $limit): LimitBuilder
    {
        $this->checkLimitParams($limit);
        $this->sql .= " LIMIT {$limit}";

        return $this;
    }

    /**
     * Checks if the limit parameters are valid.
     *
     * @param int $limit The limit to be used.
     * @return void
     */
    private function checkLimitParams(int $limit): void
    {
        $this->validateNotEmpty($limit, 'In limit clause, limit is required');
    }
}
