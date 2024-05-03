<?php

declare(strict_types=1);

namespace Yui\Core\Database\Builders;

trait QueryTrait
{
    protected string $sql = '';
    protected array $params = [];

    public function getQuery(): string
    {
        return $this->sql;
    }

    public function getParams(): array
    {
        return $this->params;
    }
}
