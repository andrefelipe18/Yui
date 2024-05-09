<?php

declare(strict_types=1);

use Yui\Core\Database\Migrations\Blueprint;
use Yui\Core\Database\Migrations\TimestampsStrategy\TimestampsStrategyInterface;
use Yui\Core\Database\Migrations\TimestampsStrategy\MySQLTimestampsStrategy;
use Yui\Core\Helpers\Dotenv;

beforeEach(function() {
	$dotenv = Mockery::mock('overload:Yui\Core\Helpers\Dotenv');
	$dotenv->shouldReceive('get')
		->with('DATABASE_CONNECTION')
		->andReturn('mysql');
});

afterEach(function () {
	Mockery::close();
});

test('Testing if the constructor correctly assigns the table name.', function () {
    $blueprint = new Blueprint('users');

    $this->assertEquals('users', $blueprint->table);
});

test('Testing if the getTimestampsStrategy() method is called during the object creation.', function () {
    // Mock the TimestampsStrategyInterface
    $strategy = Mockery::mock(TimestampsStrategyInterface::class);
    $strategy->shouldReceive('getQueryCreatedAtColumn')->andReturn('created_at');
    $strategy->shouldReceive('getQueryUpdatedAtColumn')->andReturn('updated_at');

    $blueprint = new Blueprint('users', $strategy);

    // Hack to access private property 
    $timestampsStrategy = (fn () => $this->timestampsStrategy)->call($blueprint);

    $this->assertEquals($strategy, $timestampsStrategy);
});

test('Testing if the column() method correctly adds a column to the columns list.', function () {
	$blueprint = new Blueprint('users');
	$blueprint->column('id INTEGER PRIMARY KEY');
	$blueprint->column('name VARCHAR(255)');
	$blueprint->column('email VARCHAR(255)');

	$this->assertEquals([
		'id INTEGER PRIMARY KEY',
		'name VARCHAR(255)',
		'email VARCHAR(255)'
	], $blueprint->columns);
});

test('Testing if the raw() method correctly adds a column using raw SQL to the columns list.', function () {
	$blueprint = new Blueprint('users');
	$blueprint->raw('id INTEGER PRIMARY KEY');
	$blueprint->raw('name VARCHAR(255)');
	$blueprint->raw('email VARCHAR(255)');

	$this->assertEquals([
		'id INTEGER PRIMARY KEY',
		'name VARCHAR(255)',
		'email VARCHAR(255)'
	], $blueprint->columns);
});

test('Testing if the foreign() method correctly adds a foreign key to the columns list.', function () {
	$blueprint = new Blueprint('users');
	$blueprint->foreign('user_id', 'posts', 'id');
	$blueprint->foreign('user_id', 'comments', 'id');

	$this->assertEquals([
		'FOREIGN KEY (user_id) REFERENCES posts(id)',
		'FOREIGN KEY (user_id) REFERENCES comments(id)'
	], $blueprint->columns);
});

test('Testing if the timestamps() method correctly adds timestamps columns to the columns list.', function () {
	// Mock the TimestampsStrategyInterface
	$strategy = Mockery::mock(TimestampsStrategyInterface::class);
	$strategy->shouldReceive('getQueryCreatedAtColumn')->andReturn('created_at');
	$strategy->shouldReceive('getQueryUpdatedAtColumn')->andReturn('updated_at');

	$blueprint = new Blueprint('users', $strategy);
	$blueprint->timestamps();

	$this->assertEquals([
		'created_at',
		'updated_at'
	], $blueprint->columns);
});