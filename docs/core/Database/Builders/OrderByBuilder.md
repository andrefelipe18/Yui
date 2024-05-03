# OrderByBuilder Class

`namespace: Yui\Core\Database\Builders`

## Introduction
The OrderByBuilder class is responsible for building SQL ORDER BY queries. It allows users to specify the column to order by and the order direction (ascending or descending).

## Properties

### $sql
- Type: string
- Description: The SQL query string representing the ORDER BY clause.

### $params
- Type: array<string, mixed>
- Description: An array of parameters used in the ORDER BY clause.

## Traits
- QueryTrait

## Methods

### orderBy(string $column, string $order = 'ASC'): OrderByBuilder
Orders the results by the specified column.
- Parameters:
  - `$column`: String The column to order by.
  - `$order`: String (Optional) The order to be used. Default is 'ASC'.
- Returns: OrderByBuilder The current OrderByBuilder instance.
