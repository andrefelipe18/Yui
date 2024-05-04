<?php

declare(strict_types=1);
use Yui\Core\Database\Drivers\Sqlite;

beforeEach(function () {
	$this->pdoMock = Mockery::mock(PDO::class);
});

afterEach(function () {
	Mockery::close();
});

test('successful connection', function () {
    $this->pdoMock->shouldReceive('getAttribute')
        ->with(PDO::ATTR_SERVER_INFO) 
        ->andReturn('SQLite 3.34.1');

    $connection = Sqlite::connect('/test/path', $this->pdoMock);
    expect($connection)->toBeInstanceOf(PDO::class);
});