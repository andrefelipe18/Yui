<?php

declare(strict_types=1);

namespace Yui\Core\Database\Migrations;

class Blueprint
{
	public string $table;
	public array $columns = [];
	public string $database;

	public function __construct(string $table)
	{
		$this->table = $table;
	}

	public function column(string $sql)	
	{
		$this->columns[] = $sql;
	}
}
