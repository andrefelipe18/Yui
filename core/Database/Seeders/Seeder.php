<?php

namespace Yui\Core\Database\Seeders;

use Faker\Factory;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use Yui\Core\Database\Connection;

class Seeder
{
	public string $table = '';
	public int $repeat = 1;
	/** * @var array<string, mixed> */
	public array $columns = [];
	/** * @var \Faker\Generator */
	public $faker;
	private \PDO $conn;

	public function __construct()
	{
		$this->faker = Factory::create();
		$this->conn = Connection::connect();
	}

	public function seed()
	{
		return $this;
	}

	public function table(string $table)
	{
		if (!is_string($table)) {
			throw new \Exception('Table name must be a string');
		}

		$this->table = $table;
		return $this;
	}

	public function columns(array $columns)
	{
		if (!is_array($columns)) {
			throw new \Exception('Columns must be an array');
		}

		$this->columns = $columns;
		return $this;
	}

	public function repeat(int $time)
	{
		if (!is_int($time)) {
			throw new \Exception('Repeat must be an integer');
		}

		$this->repeat = $time;
		return $this;
	}

	public function exec()
	{
		if (empty($this->table)) {
			throw new \Exception('Table name must be provided');
		} else if (empty($this->columns)) {
			throw new \Exception('Columns must be provided');
		}

		$stmt = $this->conn->prepare($this->getQuery());

		for ($i = 0; $i < $this->repeat; $i++) {
			echo "Seeding {$this->table} table..." . PHP_EOL;

			$values = array_map(function ($func) {
				return $func();
			}, $this->columns);

			$values = array_values($values);
			$stmt->execute($values);
		}
	}

	private function getQuery()
	{
		$columns = array_keys($this->columns);
		$values = array_values($this->columns);

		$columnList = implode(", ", $columns);
		$placeholders = implode(", ", array_fill(0, count($values), '?'));

		$query = "INSERT INTO $this->table ($columnList) VALUES ($placeholders)";

		return $query;
	}
}
