<?php

declare(strict_types=1);

namespace Yui\Core\Database;

abstract class Migration
{
	public string $table;
	public array $columns;

	/**
	 * Create a new table
	 */
	public function create(){
		$columns = implode(', ', array_map(function ($column, $type) {
			return "$column $type";
		}, array_keys($this->columns), $this->columns));

		$sql = "CREATE TABLE IF NOT EXISTS {$this->table} ($columns)";

		return $sql;
	}

	/**
	 * Set columns
	 */
	public function setColumns(){}

	/**
	 * Alter a table
	 */
	public function alterTable(){}

	/**
	 * Run a raw query
	 */
	public function raw(string $sql){}

	/**
	 * Rollback a migration
	 */
	public function down(){}
}