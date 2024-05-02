<?php

declare(strict_types=1);

namespace Yui\Core\Database\Builders;

use PDO;
use Yui\Core\Database\Connection;

/**
 * Class responsible for building SQL delete queries.
 */
class DeleteBuilder
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

	public function delete(): ?int
	{
		if (empty($this->whereBuilder->getQuery())) {
			return null;
		}

		$this->setWhereParams($this->whereBuilder->getParams());

		$query = $this->createQuery();

		$stmt = $this->conn->prepare($query);

		$stmt->execute($this->whereParams);

		return $stmt->rowCount();
	}

	private function createQuery(): string
	{
		$whereSql = $this->whereBuilder->getQuery();

		$query = "DELETE FROM {$this->table} {$whereSql}";

		return $query;
	}
}
