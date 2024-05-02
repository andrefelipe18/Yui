<?php

declare(strict_types=1);

namespace Yui\Core\Database\Builders;

use PDO;
use Yui\Core\Database\Connection;

/**
 * Class responsible for building SQL update queries.
 */
class UpdateBuilder
{
	protected string $table = '';
	protected array $values = [];
	protected array $whereParams = [];
	protected WhereBuilder $whereBuilder;
	protected PDO $conn;

	/**
	 * InsertBuilder class constructor.
	 *
	 * @param string $table Name of the table where the insertion will be performed.
	 */
	public function __construct(string $table, WhereBuilder $whereBuilder)
	{
		$this->table = $table;
		$this->whereBuilder = $whereBuilder;
		$this->conn = Connection::connect();
	}

	public function setWhereParams(array $whereParams)
	{
		$this->whereParams = $whereParams;
	}

	public function update(array $values): ?int
	{
		if (empty($this->whereBuilder->getQuery())) {
			return null;			
		}

		$this->setWhereParams($this->whereBuilder->getParams());

		$this->validateValues($values);
		$query = $this->createQuery($values);

		$stmt = $this->conn->prepare($query);
		$stmt->execute(array_merge(array_values($values), $this->whereParams));

		return $stmt->rowCount();
	}

	private function createQuery(array $values): string
	{
		$set = [];

		foreach ($values as $column => $value) {
			$set[] = "{$column} = ?";
		}

		$set = implode(', ', $set);
		$whereSql = $this->whereBuilder->getQuery();

		$query = "UPDATE {$this->table} SET {$set} {$whereSql}";

		return $query;
	}

	/**
	 * Validates the values to be updated.
	 *
	 * @param array $values The values to be updated.
	 * @return void
	 */
	private function validateValues(array $values): void
	{
		if (empty($values)) {
			throw new \Exception('In update clause, values are required');
		}

		foreach ($values as $key => $value) {
			if (is_int($key)) {
				throw new \Exception('In update clause, associative array is required');
			}
		}
	}
}
