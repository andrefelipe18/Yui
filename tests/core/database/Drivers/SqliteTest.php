<?php

declare(strict_types=1);
use Yui\Core\Database\Drivers\Sqlite;
use PHPUnit\Framework\Attributes\Test;
/**
 * Run after each test method
 */
afterEach(function () {
    unlink('sqlite.db');
});

test('successful connection', function () {
    file_put_contents('sqlite.db', '');
    $path = 'sqlite.db';

    $connection = Sqlite::connect($path);
    expect($connection)->toBeInstanceOf(PDO::class);
});