<?php

declare(strict_types=1);

namespace Yui\Core\Database;

use PDO;

class DB
{
   protected string $table = '';
   protected string $query = '';
   protected string $whereSql = '';
   protected array $columns = [];
   protected array $whereParams = [];

   public static function table(string $table)
   {
      if (empty($table)) {
         throw new \Exception('Table name is required');
      }

      $instance = new self();
      $instance->table = $table;
      return $instance;
   }

   public function select(...$columns)
   {
      foreach ($columns as $column) {
         if (empty($column)) {
            throw new \Exception('Column name is required');
         }
         if ($column === '*' && count($columns) > 1) {
            throw new \Exception('You cannot select all columns with other columns');
         }

         if($column === '*') {
            $this->columns = ['*'];
            break;
         }

         if(!in_array($column, $this->columns)) {
            $this->columns[] = $column;
         }

      }

      return $this;
   }

   public function where(string $column, string $operator, $value)
   {
      if (empty($column)) {
         throw new \Exception('Column name is required');
      }

      if (empty($operator)) {
         throw new \Exception('Operator is required');
      }

      if (empty($value)) {
         throw new \Exception('Value is required');
      }

      $this->whereSql = " WHERE {$column} {$operator} ?";
      $this->whereParams[] = $value;

      return $this;
   }

   public function get()
   {
      return $this->exec();
   }  

   private function exec()
   {
      $this->checkParams();
      $columns = implode(', ', $this->columns);
      $this->query = "SELECT {$columns} FROM {$this->table}{$this->whereSql}";

      $conn = Connection::connect();
      $stmt = $conn->prepare($this->query);

      $stmt->execute($this->whereParams);

      return $stmt->fetchAll(PDO::FETCH_OBJ);
   }

   private function checkParams()
   {
      if (empty($this->table)) {
         throw new \Exception('Table name is required');
      }

      if (empty($this->columns)) {
         throw new \Exception('Columns are required');
      }
   }
}  