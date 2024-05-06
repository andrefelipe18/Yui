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
 * @method QueryBuilder delete()
 * @method QueryBuilder orderBy(string $column, string $order = 'ASC')
 * @method QueryBuilder limit(int $limit)
 */
class QueryBuilder
{
    protected PDO $conn;
    protected string $table = '';
    /**
     * @var array<string, mixed>
     */
    protected array $builders;
    protected mixed $currentBuilder;

    public function __construct(string $table)
    {
        $this->conn = Connection::connect();
        $this->table = $table;
        $this->currentBuilder = $this;
        $this->builders = [
            'select' => new SelectBuilder(),
            'where' => new WhereBuilder(),
            'join' => new JoinBuilder(),
            'insert' => new InsertBuilder($table),
            'update' => new UpdateBuilder($table),
            'delete' => new DeleteBuilder($table),
            'orderBy' => new OrderByBuilder(),
            'limit' => new LimitBuilder(),
        ];
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
                $builder->$method(...$params);
                return $this;
            }
        }

        throw new \BadMethodCallException("The method {$method} does not exist");
    }

    /**
     * Execute the query and return the result
     * @return array<object>
     */
    public function get()
    {
        return $this->exec();
    }

    /**
     * Make the query and return the result
     * @return array<object>
     */
    private function exec(): array
    {
        $columns = $this->builders['select']->getQuery();
        $whereSql = $this->builders['where']->getQuery();
        $whereParams = $this->builders['where']->getParams();
        $joinSql = $this->builders['join']->getQuery();
        $orderBySql = $this->builders['orderBy']->getQuery();
        $limitSql = $this->builders['limit']->getQuery();

        $query = "SELECT {$columns} FROM {$this->table} {$joinSql} {$whereSql} {$orderBySql} {$limitSql}";

        $stmt = $this->conn->prepare($query);

        $stmt->execute($whereParams);

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
