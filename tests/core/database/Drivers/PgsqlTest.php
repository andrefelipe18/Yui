<?php

declare(strict_types=1);

use Yui\Core\Database\Drivers\Pgsql;

beforeEach(function () {
	$this->pdoMock = Mockery::mock(PDO::class);
});

afterEach(function () {
	Mockery::close();
});

test('successful connection', function () {
	$this->pdoMock->shouldReceive('getAttribute')
		->with(PDO::ATTR_SERVER_INFO)
		->andReturn('PostgreSQL 13.2');

	$connection = Pgsql::connect('127.0.0.1', 'test', 'root', 'root', '3306', 2, $this->pdoMock);

	expect($connection)->toBeInstanceOf(PDO::class);
});

test('connection failure', function () {
	$this->pdoMock->shouldReceive('getAttribute')
		->andThrow(new PDOException("SQLSTATE[08006] [7] connection to server at"));

	$dbname = 'wrong_database_name';

	$connection = Pgsql::connect('127.0.0.1', $dbname, 'root', 'root', '3306', 2, $this->pdoMock);

	expect($connection)->toBeInstanceOf(PDOException::class)
		->and($connection->getMessage())
		->toMatch("/SQLSTATE\[08006\] \[7\] connection to server at/");
});

test('authentication failure', function () {
	$this->pdoMock->shouldReceive('getAttribute')
		->andThrow(new PDOException("SQLSTATE[08006] [7] connection to server at"));
	$pass = 'wrong_password';

	$connection = Pgsql::connect('127.0.0.1', 'test', 'root', $pass, '3306', 2, $this->pdoMock);

	expect($connection)->toBeInstanceOf(PDOException::class)
		->and($connection->getMessage())
		->toMatch("/SQLSTATE\[08006\] \[7\] connection to server at/");
});

test('invalid port', function () {
	$this->pdoMock->shouldReceive('getAttribute')
		->andThrow(new PDOException("SQLSTATE[08006] [7] connection to server at"));

	$port = '6033';

	$connection = Pgsql::connect('127.0.0.1', 'test', 'root', 'root', $port, 1, $this->pdoMock);

	expect($connection)->toBeInstanceOf(PDOException::class)
		->and($connection->getMessage())
		->toMatch("/SQLSTATE\[08006\] \[7\] connection to server at/");
});

test('database failure', function () {
	$this->pdoMock->shouldReceive('getAttribute')
		->andThrow(new PDOException("SQLSTATE[08006] [7] connection to server at"));
	$host = '1';

	$connection = Pgsql::connect($host, 'test', 'root', 'root', '3306', 1, $this->pdoMock);

	expect($connection)->toBeInstanceOf(PDOException::class)
		->and($connection->getMessage())
		->toMatch("/SQLSTATE\[08006\] \[7\] connection to server at/");
});
