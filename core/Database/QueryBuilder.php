<?php

declare(strict_types=1);

namespace Yui\Core\Database;

use PDO;
use Yui\Core\Database\Builders\JoinBuilder;
use Yui\Core\Database\Connection;
use Yui\Core\Database\Builders\SelectBuilder;
use Yui\Core\Database\Builders\WhereBuilder;
use Yui\Core\Database\Builders\InsertBuilder;
use Yui\Core\Database\Builders\UpdateBuilder;
use Yui\Core\Database\Builders\DeleteBuilder;
use Yui\Core\Database\Builders\OrderBy;
use Yui\Core\Database\Builders\OrderByBuilder;

/**
 * @package Yui\Core\Database
 * @method QueryBuilder insert(array $values)
 * @method QueryBuilder update(array $values)
 * @method QueryBuilder select(string ...$columns)
 * @method QueryBuilder where(string $column, string $operator, string $value)
 * @method QueryBuilder andWhere(string $column, string $operator, string $value)
 * @method QueryBuilder orWhere(string $column, string $operator, string $value)
 * @method QueryBuilder join(string $table, string $first, string $operator, string $second)
 * @method QueryBuilder leftJoin(string $table, string $first, string $operator, string $second)
 * @method QueryBuilder rightJoin(string $table, string $first, string $operator, string $second)
 * @method QueryBuilder orderBy(string $column, string $order)
 * @method QueryBuilder get()
 */
class QueryBuilder
{
    protected string $table = '';
    protected string $query = '';
    protected string $joinSql = '';
    protected bool $isUpdate = false;
    protected bool $isDelete = false;
    protected array $updateParams = [];
    protected SelectBuilder $selectBuilder;
    protected WhereBuilder $whereBuilder;
    protected JoinBuilder $joinBuilder;
    protected InsertBuilder $insertBuilder;
    protected UpdateBuilder $updateBuilder;
    protected DeleteBuilder $deleteBuilder;
    protected OrderByBuilder $orderByBuilder;

    public function __construct(string $table)
    {
        $this->table = $table;
        $this->selectBuilder = new SelectBuilder();
        $this->whereBuilder = new WhereBuilder();
        $this->joinBuilder = new JoinBuilder();
        $this->insertBuilder = new InsertBuilder($table);
        $this->updateBuilder = new UpdateBuilder($table, $this->whereBuilder);
        $this->deleteBuilder = new DeleteBuilder($table, $this->whereBuilder);
        $this->orderByBuilder = new OrderByBuilder();
    }

    public function __call($method, $params)
    {
        switch ($method) {
            case 'insert':
                $this->insertBuilder->insert(...$params);
                break;
            case 'update':
                $this->isUpdate = true;
                $this->updateParams = $params[0];
                break;
            case 'delete':
                $this->isDelete = true;
                $this->deleteBuilder->delete();
                break;
            case 'select':
                $this->selectBuilder->select(...$params);
                break;
            case 'where':
                $this->whereBuilder->where(...$params);
                if($this->isUpdate) {
                    $this->updateBuilder->update($this->updateParams);
                } else if($this->isDelete) {
                    $this->deleteBuilder->delete();
                }
                break;
            case 'andWhere':
                $this->whereBuilder->andWhere(...$params);
                break;
            case 'orWhere':
                $this->whereBuilder->orWhere(...$params);
                break;
            case 'join':
                $this->joinBuilder->join(...$params);
                break;
            case 'leftJoin':
                $this->joinBuilder->leftJoin(...$params);
                break;
            case 'rightJoin':
                $this->joinBuilder->rightJoin(...$params);
                break;
            case 'orderBy':
                $this->orderByBuilder->orderBy(...$params);
                break;
            case 'get':
                return $this->exec();
        }

        return $this;
    }

    private function exec()
    {
        $columns = $this->selectBuilder->getQuery();
        $whereSql = $this->whereBuilder->getQuery();
        $whereParams = $this->whereBuilder->getParams();
        $joinSql = $this->joinBuilder->getQuery();
        $orderBySql = $this->orderByBuilder->getQuery();

        $this->query = "SELECT {$columns} FROM {$this->table} {$joinSql} {$whereSql} {$orderBySql}";

        $conn = Connection::connect();
        $stmt = $conn->prepare($this->query);

        $stmt->execute($whereParams);

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
