# UpsertBuilder Class

`namespace: Yui\Core\Database\Builders`

The UpsertBuilder class is responsible for building SQL upsert queries. It allows inserting new rows into a table or updating existing rows based on unique keys.

## Properties

### $table
- Type: string
- Description: The name of the table where the insertion or update will be performed.

### $values
- Type: array<string, mixed>
- Description: An associative array containing the column-value pairs to be inserted or updated.

### $conn
- Type: PDO
- Description: The PDO connection used for database operations.

### $testingPdo
- Type: PDO|null
- Description: The PDO instance used for testing purposes.

## Methods

### __construct(string $table, ?PDO $testingPdo = null)

Constructor for the UpsertBuilder class.

- Parameters:
  - `$table`: The name of the table where the insertion or update will be performed.
  - `$testingPdo`: (Optional) A PDO instance used for testing purposes.

### upsert(array $values, array $uniqueKeys, array $updateColumns): UpsertBuilder

Executes an upsert operation, inserting new rows or updating existing ones based on unique keys.

- Parameters:
  - `$values`: An associative array containing the column-value pairs to be inserted or updated.
  - `$uniqueKeys`: An array of unique keys to identify existing rows.
  - `$updateColumns`: An array of columns to update if a row already exists.
- Returns: `UpsertBuilder` The current instance of the UpsertBuilder.

### Private Methods

#### insert(array $values): void

Inserts the provided values into the table.

- Parameters:
  - `$values`: An associative array containing the column-value pairs to be inserted.
- Throws: `\PDOException` If an error occurs when inserting the values.

#### update(array $values, array $uniqueKeys): void

Updates existing rows in the table based on unique keys.

- Parameters:
  - `$values`: An associative array containing the column-value pairs to be updated.
  - `$uniqueKeys`: An array of unique keys to identify existing rows.
- Throws: `\PDOException` If an error occurs when updating the values.

### rowExists(array $values, array $uniqueKeys): bool

Checks if a row with the provided unique keys already exists in the table.

- Parameters:
  - `$values`: An associative array containing the column-value pairs to be checked.
  - `$uniqueKeys`: An array of unique keys to identify existing rows.
- Returns: `bool` True if a row with the unique keys already exists, false otherwise.
- Throws: `\Exception` If a unique key is not found in the values.

#### isDuplicateKeyError(\PDOException $e): bool

Checks if the provided exception is due to a duplicate key error.

- Parameters:
  - `$e`: The PDOException to be checked.
- Returns: `bool` True if the exception is due to a duplicate key error, false otherwise.

#### validateValues(array $values): void

Validates the values to be inserted.

- Parameters:
  - `$values`: An associative array containing the column-value pairs to be inserted.
- Throws: `\Exception` if the values are empty.
