<?php

namespace Yui\Core\Database;

class Seeder
{
	public string $table = '';

	public function table(string $table)
	{
		if(!is_string($table)){
			throw new \Exception('');
		}
		$this->table = $table;
		return $this;
	}

	public function columns(array $columns)
	{
		//Validate columns 
		return $this;
	}

	public function repeat(int $time)
	{
		return $this;
	}

	public function exec()
	{
		
	}
}