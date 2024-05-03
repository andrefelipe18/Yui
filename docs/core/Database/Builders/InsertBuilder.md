# InsertBuilder Class

`namespace: Yui\Core\Database\Builders`

## Introduction
The InsertBuilder class is responsible for building SQL INSERT queries. It allows users to specify the table into which values will be inserted and the values to be inserted.

## Properties

### $table
- Type: string
- Description: The name of the table where values will be inserted.

### $values
- Type: array<string, mixed>
- Description: An array of values to be inserted into the table.

### $conn
- Type: PDO
- Description: The PDO database connection.

## Methods

### __construct(string $table)
Constructor method to initialize the InsertBuilder instance with the specified table name.
- Parameters:
  - `$table`: String The name of the table where values will be inserted.
- Returns: Void

### insert(array $values): ?string
Inserts the specified values into the table.
- Parameters:
  - `$values`: Array An array of values to be inserted into the table.
- Returns: String|null The ID of the last inserted row, or null if no row was inserted.

### createQuery(array $values): string
Creates the SQL query to insert values into the table.
- Parameters:
  - `$values`: Array An array of values to be inserted into the table.
- Returns: String The SQL query.

### validateValues(array $values): void
Validates the values to be inserted into the table.
- Parameters:
  - `$values`: Array An array of values to be inserted into the table.
- Throws: \Exception If the values are not valid.
