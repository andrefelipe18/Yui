<?php

declare(strict_types=1);

use Yui\Core\Database\Drivers\Mysql;
use Mockery as m;

beforeEach(function () {
	$this->pdoMock = m::mock(PDO::class);
});

afterEach(function () {
	m::close();
});

test('successful connection', function () {
    $this->pdoMock->shouldReceive('getAttribute')
        ->with(PDO::ATTR_SERVER_INFO) 
        ->andReturn('MySQL 8.0.23');

    $connection = Mysql::connect('127.0.0.1', 'test', 'root', 'root', '3306', 30, $this->pdoMock);

    expect($connection)->toBeInstanceOf(PDO::class);
});

test('connection failure', function () {
	$pdoException = new PDOException("SQLSTATE[HY000] [1049] Unknown database 'wrong_database'");
	$this->pdoMock->shouldReceive('getAttribute')
		->andThrow($pdoException);

	$connection = Mysql::connect('127.0.0.1', 'wrong_database', 'root', 'root', '3306', 2, $this->pdoMock);

	expect($connection)->toBeInstanceOf(PDOException::class)
		->and($connection->getMessage())
		->toMatch("/SQLSTATE\[HY000\] \[1049\] Unknown database '(.*)'/");
});

test('authentication failure', function (){
	$this->pdoMock->shouldReceive('getAttribute')
		->andThrow(new PDOException("SQLSTATE[HY000] [1045] Access denied for user 'root' (using password: YES)"));

	$connection = Mysql::connect('127.0.0.1', 'test', 'root', 'wrongPass', '3306', 2, $this->pdoMock);

	expect($connection)->toBeInstanceOf(PDOException::class)
		->and($connection->getMessage())
		->toMatch("/SQLSTATE\[HY000\] \[1045\] Access denied for user '(.*)' \(using password: YES\)/");
});

test('invalid port', function (){
	$this->pdoMock->shouldReceive('getAttribute')
		->andThrow(new PDOException("SQLSTATE[HY000] [2002] Connection refused"));

	$port = '6033';

	$connection = Mysql::connect('127.0.0.1', 'test', 'root', 'root', $port, 1, $this->pdoMock);

	expect($connection)->toBeInstanceOf(PDOException::class)
		->and($connection->getMessage())
		->toMatch("/SQLSTATE\[HY000\] \[2002\] Connection refused/");
});

test('database failure', function (){
	$this->pdoMock->shouldReceive('getAttribute')
		->andThrow(new PDOException("SQLSTATE[HY000] [2002] Connection timed out"));
	$host = '1';

	$connection = Mysql::connect($host,  'test', 'root', 'root', '3306', 1, $this->pdoMock);

	expect($connection)->toBeInstanceOf(PDOException::class)
		->and($connection->getMessage())
		->toMatch("/SQLSTATE\[HY000\] \[2002\] Connection timed out/");
});
