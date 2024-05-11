<?php

declare(strict_types=1);

namespace Yui\Core\Database\Seeders;

use Faker\Factory as Faker;
use Faker\Generator;
use PDO;
use PDOStatement;
use Yui\Core\Database\Connection;

/**
 * Class Seeder
 * @package Yui\Core\Database\Seeders
 */
class Seeder
{
    public string $table = '';
    public int $repeat = 1;

    /** @var array<string, callable> */
    public array $columns = [];
    /** @var Generator */
    public $faker;
    private PDO $conn;

    public function __construct()
    {
        $this->faker = Faker::create();
        $this->conn = Connection::connect();
    }

    /**
     * Function to start seeding
     * @return Seeder $this
     */
    public function seed(): self
    {
        return $this;
    }

    /**
     * Function to set table name
     * @param string $table
     * @return Seeder $this
     */
    public function table(string $table): self
    {
        $this->table = $table;
        return $this;
    }

    /**
     * Function to set columns
     * @param array<string, callable> $columns
     * @return Seeder $this
     */
    public function columns(array $columns): self
    {
        $this->columns = $columns;
        return $this;
    }

    /**
     * Function to set repeat
     * @param int $time
     * @return Seeder $this
     */
    public function repeat(int $time): self
    {
        $this->repeat = $time;
        return $this;
    }

    /**
     * Function to execute the seeding
     * @throws \Exception
     * @return void
     */
    public function exec(): void
    {
        $this->checkTableAndColumns();

        $stmt = $this->prepareStatement();

        for ($i = 0; $i < $this->repeat; $i++) {
            echo "Seeding {$this->table} table..." . PHP_EOL;
            $values = array_map(fn ($func) => $func(), $this->columns);
            $stmt->execute($values);
        }
    }

    /**
     * Function to prepare the statement
     * @return PDOStatement
     */
    private function prepareStatement(): PDOStatement
    {
        $columns = array_keys($this->columns);
        $placeholders = implode(", ", array_fill(0, count($this->columns), '?'));

        $query = "INSERT INTO $this->table (" . implode(", ", $columns) . ") VALUES ($placeholders)";

        return $this->conn->prepare($query);
    }

    /**
     * Function to check table and columns
     * @throws \Exception
     * @return void
     */
    private function checkTableAndColumns(): void
    {
        if (empty($this->table)) {
            throw new \Exception('Table name must be provided');
        } elseif (empty($this->columns)) {
            throw new \Exception('Columns must be provided');
        }
    }
}
