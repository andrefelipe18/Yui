# JoinBuilder Class

`namespace: Yui\Core\Database\Builders`

## Introduction
The JoinBuilder class is responsible for building SQL JOIN queries. It allows users to specify the tables to join and the join conditions.

## Properties

### $sql
- Type: string
- Description: The SQL query string representing the JOIN clause.

### $params
- Type: array<int|string, mixed>
- Description: An array of parameters used in the JOIN clause.

## Traits
- QueryTrait

## Methods

### join(string $table, string $column1, string $operator, string $column2): JoinBuilder
Joins two tables using the JOIN clause.
- Parameters:
  - `$table`: String The table to join.
  - `$column1`: String The column from the first table.
  - `$operator`: String The operator to be used in the join clause.
  - `$column2`: String The column from the second table.
- Returns: JoinBuilder The current JoinBuilder instance.

### leftJoin(string $table, string $column1, string $operator, string $column2): JoinBuilder
Joins two tables using the LEFT JOIN clause.
- Parameters:
  - `$table`: String The table to join.
  - `$column1`: String The column from the first table.
  - `$operator`: String The operator to be used in the join clause.
  - `$column2`: String The column from the second table.
- Returns: JoinBuilder The current JoinBuilder instance.

### rightJoin(string $table, string $column1, string $operator, string $column2): JoinBuilder
Joins two tables using the RIGHT JOIN clause.
- Parameters:
  - `$table`: String The table to join.
  - `$column1`: String The column from the first table.
  - `$operator`: String The operator to be used in the join clause.
  - `$column2`: String The column from the second table.
- Returns: JoinBuilder The current JoinBuilder instance.
