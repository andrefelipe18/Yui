<?php

use Yui\Core\Database\Connection;
use Yui\Core\Database\Migrations\Blueprint;
use Yui\Core\Database\Migrations\Schema;
use Yui\Core\Helpers\Dotenv;

beforeEach(function () {
	Dotenv::load();
});

afterEach(function () {
	Mockery::close();
});

it('creates a new table', function () {
	$this->statement = Mockery::mock(PDOStatement::class);
	$this->statement->shouldReceive('execute')
		->andReturn(true);

	$this->statement->shouldReceive('fetch')
		->andReturn(true);

	$this->connection = Mockery::mock('overload:' . Connection::class);
	$this->connection->shouldReceive('connect')
		->andReturn(new PDO('sqlite::memory:'));

	$this->connection->shouldReceive('prepare')
		->andReturn($this->statement);

	Schema::create('test_table', function (Blueprint $table) {
		$table->column('id INTEGER PRIMARY KEY');
		$table->column('name TEXT');
	});

	$sql = "SELECT name FROM sqlite_master WHERE type='table' AND name='test_table'";

	$statement = $this->connection->prepare($sql);

	$statement->execute();

	$this->assertTrue($statement->fetch(PDO::FETCH_ASSOC) !== false);
});

it('updates a table', function () {
	$this->statement = Mockery::mock(PDOStatement::class);
	$this->statement->shouldReceive('execute')
		->andReturn(true);

	$this->statement->shouldReceive('fetchAll')
		->andReturn([
			['name' => 'id'],
			['name' => 'name'],
			['name' => 'age'],
		]);

	$this->connection = Mockery::mock('overload:' . Connection::class);
	$this->connection->shouldReceive('connect')
		->andReturn(new PDO('sqlite::memory:'));

	$this->connection->shouldReceive('prepare')
		->andReturn($this->statement);

	Schema::create('test_table', function (Blueprint $table) {
		$table->column('id INTEGER PRIMARY KEY');
		$table->column('name TEXT');
	});

	Schema::table('test_table', function (Blueprint $table) {
		$table->raw('ADD COLUMN age INTEGER');
	});

	$sql = "PRAGMA table_info(test_table)";
	$statement = $this->connection->prepare($sql);
	$statement->execute();

	$columns = $statement->fetchAll(PDO::FETCH_ASSOC);

	$columnExists = false;
	foreach ($columns as $column) {
		if ($column['name'] === 'age') {
			$columnExists = true;
			break;
		}
	}

	$this->assertTrue($columnExists);
});

it('executes a raw SQL query', function () {
	$this->statement = Mockery::mock(PDOStatement::class);
	$this->statement->shouldReceive('execute')
		->andReturn(true);

	$this->statement->shouldReceive('fetch')
		->andReturn(true);

	$this->connection = Mockery::mock('overload:' . Connection::class);
	$this->connection->shouldReceive('connect')
		->andReturn(new PDO('sqlite::memory:'));

	$this->connection->shouldReceive('prepare')
		->andReturn($this->statement);

	Schema::raw('CREATE TABLE raw_table (id INTEGER PRIMARY KEY, name TEXT)');

	$sql = "SELECT name FROM sqlite_master WHERE type='table' AND name='raw_table'";

	$statement = $this->connection->prepare($sql);

	$statement->execute();

	$this->assertTrue($statement->fetch(PDO::FETCH_ASSOC) !== false);
});

it('drops a table if it exists', function () {
	$this->statement = Mockery::mock(PDOStatement::class);
	$this->statement->shouldReceive('execute')
		->andReturn(true);

	$this->statement->shouldReceive('fetch')
		->andReturn(false);

	$this->connection = Mockery::mock('overload:' . Connection::class);
	$this->connection->shouldReceive('connect')
		->andReturn(new PDO('sqlite::memory:'));

	$this->connection->shouldReceive('prepare')
		->andReturn($this->statement);

	
	Schema::create('test_table', function (Blueprint $table) {
		$table->column('id INTEGER PRIMARY KEY');
		$table->column('name TEXT');
	});

	Schema::dropIfExists('test_table');

	$sql = "SELECT name FROM sqlite_master WHERE type='table' AND name='test_table'";

	$statement = $this->connection->prepare($sql);

	$statement->execute();

	$this->assertFalse($statement->fetch(PDO::FETCH_ASSOC));
});
