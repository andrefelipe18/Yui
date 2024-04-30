<?php

declare(strict_types=1);

namespace Yui\Core\Database;

use PDO;
use Yui\Core\Database\Builders\JoinBuilder;
use Yui\Core\Database\Connection;
use Yui\Core\Database\Builders\SelectBuilder;
use Yui\Core\Database\Builders\WhereBuilder;
use Yui\Core\Database\Builders\InsertBuilder;

class QueryBuilder
{
    protected string $table = '';
    protected string $query = '';
    protected string $joinSql = '';
    protected SelectBuilder $selectBuilder;
    protected WhereBuilder $whereBuilder;
    protected JoinBuilder $joinBuilder;
    protected InsertBuilder $insertBuilder;

    public function __construct(string $table)
    {
        $this->table = $table;
        $this->selectBuilder = new SelectBuilder();
        $this->whereBuilder = new WhereBuilder();
        $this->joinBuilder = new JoinBuilder();
        $this->insertBuilder = new InsertBuilder($table);
    }

    public function __call($method, $params)
    {
        switch ($method) {
            case 'insert';
                $this->insertBuilder->insert(...$params);
                break;
            case 'select':
                $this->selectBuilder->select(...$params);
                break;
            case 'where':
                $this->whereBuilder->where(...$params);
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

        $this->query = "SELECT {$columns} FROM {$this->table} {$joinSql} {$whereSql}";

        $conn = Connection::connect();
        $stmt = $conn->prepare($this->query);

        $stmt->execute($whereParams);

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
