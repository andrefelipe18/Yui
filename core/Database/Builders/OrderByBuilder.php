<?php

declare(strict_types=1);

namespace Yui\Core\Database\Builders;

class OrderByBuilder
{
	protected string $orderBySql = '';

	public function getQuery()
    {
        return $this->orderBySql;
    }

	public function orderBy(string $column, string $order = 'ASC')
	{
		$this->checkOrderByParams($column, $order);
		$this->orderBySql .= " ORDER BY {$column} {$order}";

		return $this;
	}

	private function checkOrderByParams(string $column, string $order)
	{
		if (empty($column)) {
			throw new \Exception('In order by clause, column name is required');
		}

		if (empty($order)) {
			throw new \Exception('In order by clause, order is required');
		}
	}
}