<?php

declare(strict_types=1);

namespace Tests\Yui\Core\Database\Drivers;

use Yui\Core\Database\Drivers\Sqlite;
use PHPUnit\Framework\Attributes\Test;
use PDO;
use PDOException;
use PHPUnit\Framework\TestCase;


class SqliteTest extends TestCase
{
    /**
     * Run after each test method
     */
    protected function tearDown(): void
    {
        unlink('sqlite.db');
        parent::tearDown();
    }

    #[Test]
    public function successful_connection()
    {
        file_put_contents('sqlite.db', '');
        $path = 'sqlite.db';

        $connection = Sqlite::connect($path);
        $this->assertInstanceOf(PDO::class, $connection);
    }
}