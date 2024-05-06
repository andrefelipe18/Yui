<?php

declare(strict_types=1);

namespace Yui\Core\Database\Builders;

use PDO;
use Yui\Core\Database\Connection;
use Yui\Core\Database\Builders\Builder;

/**
 * Class responsible for building SQL insert queries.
 *
 * @package Yui\Core\Database\Builders
 */
class InsertBuilder extends Builder
{
    protected string $table = '';
    /** @var array<string, mixed> */
    protected array $values = [];
    protected ?string $insertId = null;
    protected PDO $conn;
    protected ?PDO $testingPdo; //Var to tests suite

    /**
     * InsertBuilder class constructor.
     *
     * @param string $table Name of the table where the insertion will be performed.
     */
    public function __construct(string $table, ?PDO $testingPdo = null)
    {
        $this->table = $table;
        $this->conn = Connection::connect();
        $this->testingPdo = $testingPdo;
    }

    /**
     * Inserts the values into the specified table.
     * @param array<mixed, mixed> $values The values to be inserted.
     * @return string|null The ID of the last inserted row, or null if no row was inserted.
     */
    public function insert(array $values): InsertBuilder
    {
        $this->validateValues($values);
        $query = $this->createQuery($values);

        if($this->testingPdo !== null) {
            $this->testingPdo->exec($query);
        } else {
            $this->conn->exec($query);
        }

        $this->insertId = $this->conn->lastInsertId();
        return $this;
    }

    /**
     * Creates the SQL query to be executed.
     *
     * @param array<mixed, mixed> $values The values to be inserted.
     * @return string The SQL query.
     */
    private function createQuery(array $values): string
    {
        $columns = '';
        $isMultiDimensional = isset($values[0]) && is_array($values[0]);

        if ($isMultiDimensional) {
            $columns = implode(', ', array_keys($values[0]));
            $values = array_map(function ($value) {
                return "('" . implode("', '", $value) . "')";
            }, $values);
            $values = implode(', ', $values);
        } else {
            $columns = implode(', ', array_keys($values));
            $values = "('" . implode("', '", $values) . "')";
        }

        return "INSERT INTO {$this->table} ({$columns}) VALUES {$values}";
    }

    /**
     * Returns the ID of the last inserted row.
     * @return string|null The ID of the last inserted row, or null if no row was inserted.
     */
    public function getLastInsertedID(): ?string
    {
        return $this->insertId;
    }

    /**
     * Validates the values to be inserted.
     *
     * @param array<mixed, mixed> $values The values to be inserted.
     * @throws \Exception If the values are not valid.
     */
    private function validateValues(array $values): void
    {
        if (empty($values)) {
            throw new \Exception('Values cannot be empty');
        }

        if (isset($values[0]) && is_array($values[0])) {
            $columns = array_keys($values[0]);
            foreach ($values as $value) {
                if (array_keys($value) !== $columns) {
                    throw new \Exception('All values must have the same keys');
                }
            }
        }
    }
}
