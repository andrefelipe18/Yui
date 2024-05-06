<?php

declare(strict_types=1);

use Yui\Core\Database\DB;


beforeEach(function () {
	$this->pdo = new PDO('sqlite::memory:');
	$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$this->pdo->exec('CREATE TABLE users (id INTEGER PRIMARY KEY, name TEXT)');
	$this->pdo->exec('CREATE TABLE posts (id INTEGER PRIMARY KEY, title TEXT, user_id INTEGER)');
	$this->pdo->exec('CREATE TABLE comments (id INTEGER PRIMARY KEY, content TEXT, post_id INTEGER)');
});

afterEach(function () {
	$this->pdo->exec('DELETE FROM users');
	$this->pdo->exec('DELETE FROM posts');
	$this->pdo->exec('DELETE FROM comments');
	$this->pdo = null;
});

test('Testing if the __call magic method works correctly for existing methods in the builders.', function () {
	DB::table('users', $this->pdo)
		->insert(['name' => 'John Doe']);

	$testing = DB::table('users', $this->pdo)
		->select('name')
		->where('id', '=', 1)
		->get();

	$this->assertEquals('John Doe', $testing[0]->name);
});

test('Testing if the __call magic method throws an exception for methods that do not exist in the builders.', function () {
	$this->expectException(BadMethodCallException::class);
	$this->expectExceptionMessage('The method nonExistentMethod does not exist');

	DB::table('users', $this->pdo)
		->insert(['name' => 'John Doe'])
		->nonExistentMethod();
});

test('Testing if the get method returns the expected results.', function () {
	DB::table('users', $this->pdo)
		->insert(['name' => 'John Doe']);

	$testing = DB::table('users', $this->pdo)
		->select('name')
		->where('id', '=', 1)
		->get();

	$this->assertEquals('John Doe', $testing[0]->name);
});

test('Testing if the insert method correctly inserts data into the database.', function () {
	DB::table('users', $this->pdo)
		->insert(['name' => 'John Doe'])
		->get();

	$users = DB::table('users', $this->pdo)
		->select('name', 'id')
		->get();

	$this->assertEquals('John Doe', $users[0]->name);
});

test('Testing if the update method correctly updates data in the database.', function () {
	DB::table('users', $this->pdo)
		->insert(['name' => 'John Doe']);

	DB::table('users', $this->pdo)
		->update(['name' => 'Jane Doe'])
		->where('id', '=', 1);

	$users = DB::table('users', $this->pdo)
		->select('name', 'id')
		->get();

	$this->assertEquals('Jane Doe', $users[0]->name);
});

test('Testing if the delete method correctly deletes data from the database.', function () {
	DB::table('users', $this->pdo)
		->insert(['name' => 'John Doe']);

	DB::table('users', $this->pdo)
		->delete()
		->where('id', '=', 1);

	$users = DB::table('users', $this->pdo)
		->select('name', 'id')
		->get();

	$this->assertEmpty($users);
});

test('Testing if the select method correctly returns data from the database.', function () {
	DB::table('users', $this->pdo)
		->insert(['name' => 'John Doe']);

	$users = DB::table('users', $this->pdo)
		->select('name', 'id')
		->get();

	$this->assertEquals('John Doe', $users[0]->name);
});

test('Testing if the where method correctly filters data from the database.', function () {
	DB::table('users', $this->pdo)
		->insert(['name' => 'John Doe'])
		->insert(['name' => 'Jane Doe']);

	$users = DB::table('users', $this->pdo)
		->select('name', 'id')
		->where('name', '=', 'John Doe')
		->get();

	$this->assertEquals('John Doe', $users[0]->name);
});

test('Testing if the andWhere method correctly adds an AND condition to the query.', function () {
	DB::table('users', $this->pdo)
		->insert(['name' => 'John Doe'])
		->insert(['name' => 'Jane Doe']);

	$users = DB::table('users', $this->pdo)
		->select('name', 'id')
		->where('name', '=', 'John Doe')
		->andWhere('id', '=', 1)
		->get();

	$this->assertEquals('John Doe', $users[0]->name);
});

test('Testing if the orWhere method correctly adds an OR condition to the query.', function () {
	DB::table('users', $this->pdo)
		->insert(['name' => 'John Doe'])
		->insert(['name' => 'Jane Doe']);

	$users = DB::table('users', $this->pdo)
		->select('name', 'id')
		->where('name', '=', 'John Doe')
		->orWhere('id', '=', 2)
		->get();

	$this->assertEquals('John Doe', $users[0]->name);
});

test('Testing if the join method correctly joins tables.', function () {
	DB::table('users', $this->pdo)
		->insert(['name' => 'John Doe']);

	DB::table('posts', $this->pdo)
		->insert(['title' => 'Post 1', 'user_id' => 1]);

	$users = DB::table('users', $this->pdo)
		->select('users.name', 'posts.title')
		->join('posts', 'users.id', '=', 'posts.user_id')
		->get();

	$this->assertEquals('John Doe', $users[0]->name);
	$this->assertEquals('Post 1', $users[0]->title);
});

test('Testing if the leftJoin method correctly joins tables with a LEFT JOIN.', function () {
	DB::table('users', $this->pdo)
		->insert(['name' => 'John Doe']);

	DB::table('posts', $this->pdo)
		->insert(['title' => 'Post 1', 'user_id' => 1]);

	$users = DB::table('users', $this->pdo)
		->select('users.name', 'posts.title')
		->leftJoin('posts', 'users.id', '=', 'posts.user_id')
		->get();

	$this->assertEquals('John Doe', $users[0]->name);
	$this->assertEquals('Post 1', $users[0]->title);
});

test('Testing if the orderBy method correctly orders the results.', function () {
	DB::table('users', $this->pdo)
	->insert(['name' => 'John Doe'])
	->insert(['name' => 'Jane Doe']);

	$users = DB::table('users', $this->pdo)
		->select('name', 'id')
		->orderBy('name', 'asc')
		->get();

	$this->assertEquals('Jane Doe', $users[0]->name);
});

test('Testing if the limit method correctly limits the number of results.', function () {
	DB::table('users', $this->pdo)
		->insert(['name' => 'John Doe'])
		->insert(['name' => 'Jane Doe']);

	$users = DB::table('users', $this->pdo)
		->select('name', 'id')
		->limit(1)
		->get();

	$this->assertCount(1, $users);
});

test('Testing if the raw method correctly executes a raw query.', function () {
	DB::table('users', $this->pdo)
		->insert(['name' => 'John Doe']);

	$users = DB::raw('SELECT * FROM users', testingPdo: $this->pdo);

	$this->assertEquals('John Doe', $users[0]['name']);
});
