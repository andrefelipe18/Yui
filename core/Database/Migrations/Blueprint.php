<?php

declare(strict_types=1);

namespace Yui\Core\Database\Migrations;

/**
 * This class represents a blueprint for creating a table
 * @package Yui\Core\Database\Migrations
 */
class Blueprint
{
	public string $table;
	/** @var array<string> */
	public array $columns = [];

	public function __construct(string $table)
	{
		$this->table = $table;
	}

	/**
	 * Define a column passing the column SQL
	 * 
	 * @param string $sql
	 * @return void
	 */
	public function column(string $sql): void
	{
		$this->columns[] = $sql;
	}

	/**
	 * Define or updating a column using raw SQL
	 * 
	 * @param string $sql
	 * @return void
	 */
	public function raw(string $sql): void
	{
		$this->columns[] = $sql;
	}

	/**
	 * Define a foreign key
	 * 
	 * @param string $column
	 * @param string $table
	 * @param string $references
	 * @return void
	 */
	public function foreign(string $column, string $table, string $references)
	{
		$this->columns[] = "FOREIGN KEY ($column) REFERENCES $table($references)";
	}

	/**
	 * Define timestamps columns
	 * 
	 * @return void
	 */
	public function timestamps()
	{
		$this->columns[] = 'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP';
		$this->columns[] = 'updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP';
	}
}
