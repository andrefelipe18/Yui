<?php

declare(strict_types=1);

namespace Yui\Core\Database;

use PDO;
use Yui\Core\Database\Builders\Builder;
use Yui\Core\Database\Builders\JoinBuilder;
use Yui\Core\Database\Connection;
use Yui\Core\Database\Builders\SelectBuilder;
use Yui\Core\Database\Builders\WhereBuilder;
use Yui\Core\Database\Builders\InsertBuilder;
use Yui\Core\Database\Builders\UpdateBuilder;
use Yui\Core\Database\Builders\DeleteBuilder;
use Yui\Core\Database\Builders\OrderByBuilder;
use Yui\Core\Database\Builders\LimitBuilder;
use Yui\Core\Database\Builders\UpsertBuilder;

/**
 * @package Yui\Core\Database
 *
 * @method QueryBuilder select(string $columns)
 * @method QueryBuilder where(string $column, string $operator, mixed $value)
 * @method QueryBuilder andWhere(string $column, string $operator, mixed $value)
 * @method QueryBuilder orWhere(string $column, string $operator, mixed $value)
 * @method QueryBuilder join(string $table, string $column1, string $operator, string $column2)
 * @method QueryBuilder leftJoin(string $table, string $column1, string $operator, string $column2)
 * @method QueryBuilder insert(array<string, mixed> $values)
 * @method QueryBuilder update(array<string, mixed> $values)
 * @method QueryBuilder upsert(array<string, mixed> $values, array<string> $uniqueKeys, array<string> $updateColumns)
 * @method QueryBuilder delete()
 * @method QueryBuilder orderBy(string $column, string $order = 'ASC')
 * @method QueryBuilder limit(int $limit)
 */
class QueryBuilder
{
    protected PDO $conn;
    protected string $table = '';
    /**
     * @var array<string, Builder>
     */
    protected array $builders;
    protected object $currentBuilder;
    protected ?PDO $testingPdo;

    public function __construct(string $table, ?PDO $testingPdo = null)
    {
        $this->conn = Connection::connect();
        $this->table = $table;
        $this->currentBuilder = $this;
        $this->builders = [
            'select' => new SelectBuilder(),
            'where' => new WhereBuilder(),
            'join' => new JoinBuilder(),
            'insert' => new InsertBuilder($table, $testingPdo),
            'update' => new UpdateBuilder($table, $testingPdo),
            'upsert' => new UpsertBuilder($table, $testingPdo),
            'delete' => new DeleteBuilder($table, $testingPdo),
            'orderBy' => new OrderByBuilder(),
            'limit' => new LimitBuilder(),
        ];
        $this->testingPdo = $testingPdo;
    }

    /**
     * Magic method to handle method calls
     * @param string $method
     * @param array<mixed> $params
     * @return mixed
     */
    public function __call(string $method, array $params): mixed
    {
        // If the method belongs to the current builder, direct the call to it
        if (
            $this->currentBuilder !== $this &&
            method_exists($this->currentBuilder, $method)
        ) {
            $this->currentBuilder->$method(...$params);
            return $this;
        }

        // If the method belongs to a specific builder, change the context for that builder
        foreach ($this->builders as $builderName => $builder) {
            if (method_exists($builder, $method)) {
                $this->currentBuilder = $builder; // Change the context
                if ($method === 'insert' || $method === 'update' || $method === 'delete' || $method === 'upsert') {
                    $builder->$method(...$params);
                    return $this;
                } else {
                    $builder->$method(...$params);
                    return $this;
                }
            }
        }

        throw new \BadMethodCallException("The method {$method} does not exist");
    }

    /**
     * Execute the query and return the result
     * @return array<object>|string
     */
    public function get(): array|string
    {
        return $this->exec();
    }

    /**
     * Make the query and return the result
     * @return array<object>
     */
    private function exec(): array|string
    {
        /** @var InsertBuilder $insertBuilder */
        $insertBuilder = $this->builders['insert'];
        if ($insertBuilder->getLastInsertedID() !== null) {
            return $insertBuilder->getLastInsertedID();
        }

        /** @var SelectBuilder $selectBuilder */
        $selectBuilder = $this->builders['select'];
        $columns = $selectBuilder->getQuery();

        /** @var WhereBuilder $whereBuilder */
        $whereBuilder = $this->builders['where'];
        $whereSql = $whereBuilder->getQuery();
        $whereParams = $whereBuilder->getParams();

        /** @var JoinBuilder $joinBuilder */
        $joinBuilder = $this->builders['join'];
        $joinSql = $joinBuilder->getQuery();

        /** @var OrderByBuilder $orderByBuilder */
        $orderByBuilder = $this->builders['orderBy'];
        $orderBySql = $orderByBuilder->getQuery();

        /** @var LimitBuilder $limitBuilder */
        $limitBuilder = $this->builders['limit'];
        $limitSql = $limitBuilder->getQuery();

        $query = "SELECT {$columns} FROM {$this->table} {$joinSql} {$whereSql} {$orderBySql} {$limitSql}";

        $stmt = null;
        if ($this->testingPdo === null) {
            $stmt = $this->conn->prepare($query);
        } else {
            $stmt = $this->testingPdo->prepare($query);
        }

        $stmt->execute($whereParams);

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
