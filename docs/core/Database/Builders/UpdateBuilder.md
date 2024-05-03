# UpdateBuilder

`namespace: Yui\Core\Database\Builders`

## Introduction
The UpdateBuilder class is responsible for building SQL update queries. It allows setting values to be updated and specifying conditions for the update operation.

## Properties

### $table
- Type: string
- Description: The name of the table where the update operation will be performed.

### $values
- Type: array<string, mixed>
- Description: An associative array containing the column-value pairs to be updated.

### $whereParams
- Type: array<int|string, mixed>
- Description: An array of parameters for the WHERE clause.

### $whereBuilder
- Type: WhereBuilder
- Description: An instance of WhereBuilder used to construct the WHERE clause.

### $conn
- Type: PDO
- Description: The PDO connection used for database operations.

## Methods

### __construct(string $table)
Class constructor. Initializes the UpdateBuilder with the specified table name.
- Parameters:
  - `$table`: The name of the table where the update operation will be performed.

### setWhereParams(array $whereParams): void
Sets the parameters for the WHERE clause.
- Parameters:
  - `$whereParams`: An array of parameters for the WHERE clause.
- Returns: Void

### update(array $values): UpdateBuilder
Sets the values to be updated.
- Parameters:
  - `$values`: An associative array containing the column-value pairs to be updated.
- Returns: UpdateBuilder The UpdateBuilder instance.

### where(string $column, string $operator, mixed $value): void
Sets the WHERE clause for the update query.
- Parameters:
  - `$column`: The column to be used in the WHERE clause.
  - `$operator`: The operator to be used in the WHERE clause.
  - `$value`: The value to be used in the WHERE clause.
- Returns: Void

### executeUpdate(): ?int
Executes the update query and returns the number of rows affected.
- Returns: int|null The number of rows affected by the update query, or null if no update was performed.

### createQuery(array $values): string
Creates the SQL update query.
- Parameters:
  - `$values`: An associative array containing the column-value pairs to be updated.
- Returns: string The SQL update query.

### validateValues(array $values): void
Validates the values to be updated.
- Parameters:
  - `$values`: An associative array containing the column-value pairs to be updated.
- Returns: Void
