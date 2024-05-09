<?php

declare(strict_types=1);

namespace Yui\Core\Database\Builders;

use PDO;
use Yui\Core\Database\Connection;
use Yui\Core\Database\Builders\Builder;
use Yui\Core\Database\DB;
use Yui\Core\Helpers\Dotenv;

/**
 * Class responsible for building SQL upsert queries.
 *
 * @package Yui\Core\Database\Builders
 */
class UpsertBuilder extends Builder
{
	protected string $table = '';
	/** @var array<string, mixed> */
	protected array $values = [];
	protected PDO $conn;
	protected ?PDO $testingPdo; //Var to tests suite

	/**
	 * UpsertBuilder class constructor.
	 * 
	 * @param string $table Name of the table where the insertion will be performed.
	 */
	public function __construct(string $table, ?PDO $testingPdo = null)
	{
		$this->table = $table;
		$this->conn = Connection::connect();
		$this->testingPdo = $testingPdo;
	}

	/**
	 * Try entering the values provided. If a PDOException exception is thrown and it is due to a duplicate key error, it updates the existing values.
	 *
	 *
	 * @param array $values The values to be entered or updated.
	 * @param array $uniqueKeys The unique keys that identify an existing line.
	 * @param array $updateColumns The columns to be updated if the row already exists.
	 * @return UpsertBuilder
	 * @throws \PDOException If an error occurs when entering the values and the error is not due to a duplicate key.
	 */
	public function upsert(array $values, array $uniqueKeys, array $updateColumns): UpsertBuilder
	{
		$this->validateValues($values);

		if ($this->rowExists($values, $uniqueKeys)) {
			$this->update($values, $uniqueKeys);
		} else {
			try {
				$this->insert($values);
			} catch (\PDOException $e) {
				if ($this->isDuplicateKeyError($e)) {
					$this->update($values, $uniqueKeys);
				} else {
					throw $e;
				}
			}
		}

		return $this;
	}

	/**
	 * Enter the values provided in the table.
	 *
	 * @param array $values The values to be entered.
	 * @throws \PDOException If an error occurs when entering the values.
	 */
	private function insert(array $values): void
	{
		$columns = implode(', ', array_keys($values));
		$placeholders = ':' . implode(', :', array_keys($values));

		$query = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";

		$stmt = $this->conn->prepare($query);

		if ($this->testingPdo !== null) {
			$stmt = $this->testingPdo->prepare($query);
			$stmt->execute($values);
		} else {
			$stmt = $this->conn->prepare($query);
			$stmt->execute($values);
		}
	}

	/**
	 * Updates the existing values in the table.
	 *
	 * @param array $values The values to be updated.
	 * @param array $uniqueKeys The unique keys that identify the existing line.
	 * @throws \PDOException If an error occurs when updating the values.
	 */
	private function update(array $values, array $uniqueKeys): void
	{
		$set = '';
		foreach ($values as $column => $value) {
			$set .= $column . ' = :' . $column . ', ';
		}
		$set = rtrim($set, ', ');

		$where = '';
		foreach ($uniqueKeys as $key) {
			if (!array_key_exists($key, $values)) {
				throw new \Exception("Unique key {$key} not found in values");
			}
			$where .= $key . ' = :' . $key . '_where AND ';
			$values[$key . '_where'] = $values[$key];
		}
		$where = rtrim($where, ' AND ');

		$query = "UPDATE {$this->table} SET {$set} WHERE {$where}";

		if ($this->testingPdo !== null) {
			$stmt = $this->testingPdo->prepare($query);
			$stmt->execute($values);
		} else {
			$stmt = $this->conn->prepare($query);
			$stmt->execute($values);
		}
	}

	/**
	 * Checks whether the exception provided is due to a duplicate key error.
	 *
	 * @param \PDOException $e The exception to be checked.
	 * @return bool Returns true if the exception is due to a duplicate key error, false otherwise.
	 */
	private function isDuplicateKeyError(\PDOException $e): bool
	{
		$errorCode = $e->errorInfo[1];
		return in_array($errorCode, [1062, 23505]); // 1062 is for MySQL, 23505 is for PostgreSQL
	}

	/**
	 * Checks if the row already exists in the table.
	 *
	 * @param array $values The values to be checked.
	 * @param array $uniqueKeys The unique keys that identify the existing line.
	 * @return bool Returns true if the row already exists, false otherwise.
	 * @throws \Exception If a unique key is not found in the values.
	 */
	private function rowExists(array $values, array $uniqueKeys): bool
	{
		$where = '';
		$whereValues = [];
		foreach ($uniqueKeys as $key) {
			if (!array_key_exists($key, $values)) {
				throw new \Exception("Unique key {$key} not found in values");
			}
			$where .= $key . ' = :' . $key . ' AND ';
			$whereValues[$key] = $values[$key];
		}
		$where = rtrim($where, ' AND ');

		$query = "SELECT COUNT(*) FROM {$this->table} WHERE {$where}";

		if ($this->testingPdo !== null) {
			$stmt = $this->testingPdo->prepare($query);
			$stmt->execute($whereValues);
		} else {
			$stmt = $this->conn->prepare($query);
			$stmt->execute($whereValues);
		}

		return $stmt->fetchColumn() > 0;
	}

	/**
	 * Validates the values to be inserted.
	 * 
	 * @param array<string, mixed> $values The values to be inserted.
	 * @return void
	 */
	private function validateValues(array $values): void
	{
		if (empty($values)) {
			throw new \Exception('Values cannot be empty');
		}
	}
}
