<?php

declare(strict_types=1);

namespace Yui\Core\Database;

abstract class Migration
{
	public string $table;
	public array $columns = [];

	public function setColumns()
	{
		$this->columns = [];
	}

	public function create()
	{
		$columns = implode(', ', $this->columns);
		return "CREATE TABLE IF NOT EXISTS {$this->table} ($columns)";
	}

	public function alterTable()
	{
		$columns = implode(', ', $this->columns);
		return "ALTER TABLE {$this->table} ADD COLUMN $columns";
	}

	public function raw()
	{
		return '';
	}
}