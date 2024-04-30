<?php

declare(strict_types=1);

namespace Yui\Core\Database\Builders;

class JoinBuilder
{
    protected string $joinSql = '';

    public function join(string $table, string $column1, string $operator, string $column2)
    {
		$this->checkJoinParams($table, $column1, $operator, $column2);
        $this->joinSql .= " JOIN {$table} ON {$column1} {$operator} {$column2}";

        return $this;
    }

    public function leftJoin(string $table, string $column1, string $operator, string $column2)
    {
		$this->checkJoinParams($table, $column1, $operator, $column2);
        $this->joinSql .= " LEFT JOIN {$table} ON {$column1} {$operator} {$column2}";

        return $this;
    }

    public function rightJoin(string $table, string $column1, string $operator, string $column2)
    {
		$this->checkJoinParams($table, $column1, $operator, $column2);
        $this->joinSql .= " RIGHT JOIN {$table} ON {$column1} {$operator} {$column2}";

        return $this;
    }

    public function getQuery()
    {
        return $this->joinSql;
    }

	private function checkJoinParams(string $table, string $column1, string $operator, string $column2)
	{
	   if (empty($table)) {
		  throw new \Exception('In join clause, table name is required');
	   }
 
	   if (empty($column1)) {
		  throw new \Exception('In join clause, column 1 is required');
	   }
 
	   if (empty($operator)) {
		  throw new \Exception('In join clause, operator is required');
	   }
 
	   if (empty($column2)) {
		  throw new \Exception('In join clause, column 2 is required');
	   }
	}
}