# WhereBuilder

`namespace: Yui\Core\Database\Builders`

## Introduction
The WhereBuilder class is responsible for building SQL WHERE clauses. It allows constructing WHERE clauses with conditions such as equality, inequality, or comparison.

## Properties

### $sql
- Type: string
- Description: The WHERE clause SQL string.

### $params
- Type: array<int|string, mixed>
- Description: An array of parameters for prepared statements.

## Traits
- QueryTrait

## Methods

### where(string $column, string $operator, mixed $value): WhereBuilder
Builds the WHERE clause with the specified condition.
- Parameters:
  - `$column`: The column name.
  - `$operator`: The comparison operator.
  - `$value`: The value to compare against.
- Returns: WhereBuilder The WhereBuilder instance.

### andWhere(string $column, string $operator, mixed $value): WhereBuilder
Builds the AND WHERE clause with the specified condition.
- Parameters:
  - `$column`: The column name.
  - `$operator`: The comparison operator.
  - `$value`: The value to compare against.
- Returns: WhereBuilder The WhereBuilder instance.

### orWhere(string $column, string $operator, mixed $value): WhereBuilder
Builds the OR WHERE clause with the specified condition.
- Parameters:
  - `$column`: The column name.
  - `$operator`: The comparison operator.
  - `$value`: The value to compare against.
- Returns: WhereBuilder The WhereBuilder instance.

### checkparams(string $column, string $operator, mixed $value): void
Checks if the WHERE parameters are valid.
- Parameters:
  - `$column`: The column name.
  - `$operator`: The comparison operator.
  - `$value`: The value to compare against.
- Returns: Void
