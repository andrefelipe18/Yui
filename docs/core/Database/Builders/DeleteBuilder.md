# DeleteBuilder Class

`namespace: Yui\Core\Database\Builders`

## Introduction
The DeleteBuilder class is responsible for building SQL DELETE queries. It allows users to specify the table from which rows will be deleted and apply WHERE conditions to specify which rows to delete.

## Properties

### $table
- Type: string
- Description: The name of the table from which rows will be deleted.

### $values
- Type: array<string, mixed>
- Description: An array of values used in the DELETE query.

### $whereParams
- Type: array<int|string, mixed>
- Description: An array of parameters used in the WHERE clause of the DELETE query.

### $whereBuilder
- Type: WhereBuilder
- Description: An instance of the WhereBuilder class used to construct the WHERE clause of the DELETE query.

### $conn
- Type: PDO
- Description: The PDO database connection.

### $pdo
- Type: PDO
- Description: The PDO instance to be used for the query in test mode.

## Methods

### __construct(string $table)
Constructor method to initialize the DeleteBuilder instance with the specified table name.
- Parameters:
  - `$table`: String The name of the table from which rows will be deleted.
  -  `$pdo`: PDO The PDO instance to be used for the query in test mode.
- Returns: Void

### setWhereParams(array $whereParams): void
Sets the parameters used in the WHERE clause of the DELETE query.
- Parameters:
  - `$whereParams`: Array An array of parameters used in the WHERE clause.
- Returns: Void

### delete(): DeleteBuilder
Deletes the rows that match the specified WHERE clause.
- Returns: DeleteBuilder The DeleteBuilder instance.

### where(string $column, string $operator, mixed $value): void
Sets the WHERE clause for the DELETE query.
- Parameters:
  - `$column`: String The column to be used in the WHERE clause.
  - `$operator`: String The operator to be used in the WHERE clause.
  - `$value`: Mixed The value to be used in the WHERE clause.
- Returns: Void
