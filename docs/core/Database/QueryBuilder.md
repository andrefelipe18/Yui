# QueryBuilder Class

`namespace: Yui\Core\Database`

## Introduction
The QueryBuilder class provides a fluent interface for building SQL queries. It allows users to construct SELECT, INSERT, UPDATE, and DELETE queries dynamically. It also supports adding WHERE conditions, JOIN clauses, and ORDER BY clauses to the queries.

## Properties

### $conn
- Type: PDO
- Description: The PDO database connection.

### $table
- Type: string
- Description: The name of the database table being queried.

### $builders
- Type: array
- Description: An array containing instances of various query builder classes (e.g., SelectBuilder, WhereBuilder, JoinBuilder).

### $currentBuilder
- Type: mixed
- Description: The current query builder instance.

## Methods

### __construct(string $table)
Constructor method to initialize the QueryBuilder instance.
- Parameters:
  - `$table`: String The name of the database table.
- Returns: Void

### __call(string $method, array $params): mixed
Magic method to handle method calls dynamically. It delegates method calls to the appropriate query builder instance based on the method name.
- Parameters:
  - `$method`: String The name of the method being called.
  - `$params`: Array The parameters passed to the method.
- Returns: Mixed The result of the method call.

### get(): array<object>
Executes the query and returns the result as an array of objects.
- Returns: Array An array of objects representing the query result.

### exec(): array<object>
Executes the constructed SQL query and returns the result as an array of objects. This method is private and is called internally by the `get()` method.
- Returns: Array An array of objects representing the query result.
