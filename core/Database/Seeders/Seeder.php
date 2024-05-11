<?php

namespace Yui\Core\Database\Seeders;

use Faker\Factory;

class Seeder
{
	public string $table = '';
	public int $repeat = 1;
	public string $columns = '';
	/** * @var \Faker\Generator */
	public $faker;

	public function __construct()
	{
		$this->faker = Factory::create();
	}

	public function seed()
	{
		return $this;
	}

	public function table(string $table)
	{
		if(!is_string($table)){
			throw new \Exception('Table name must be a string');
		}

		$this->table = $table;
		return $this;
	}

	public function columns(array $columns)
	{
		if(!is_array($columns)){
			throw new \Exception('Columns must be an array');
		}

		$columns = array_map(function($column){
			return "'$column'";
		}, $columns);

		$columns = implode(',', $columns);

		$this->columns = $columns;
		return $this;
	}

	public function repeat(int $time)
	{
		if(!is_int($time)){
			throw new \Exception('Repeat must be an integer');
		}
		return $this;
	}

	public function exec()
	{
		if(empty($this->table)){
			throw new \Exception('Table name must be provided');
		} else if(empty($this->columns)){
			throw new \Exception('Columns must be provided');
		}

		$columns = $this->columns;

		$query = "INSERT INTO $this->table VALUES ($columns)";

		echo $query;
	}
}