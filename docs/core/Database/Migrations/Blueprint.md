# Blueprint Class

`namespace: Yui\Core\Database\Migrations`

This class represents a blueprint for creating a table.

## Introduction

The Blueprint class provides methods to define columns, foreign keys, and timestamps for creating a table schema.

## Properties

### $table
- Type: string
- Description: Stores the name of the table being created.

### $columns
- Type: array<string>
- Description: Stores an array of column definitions.

### $timestampsStrategy
- Type: TimestampsStrategyInterface
- Description: Stores the timestamps strategy for the database.

## Methods

### __construct(string $table, ?TimestampsStrategyInterface $timestampsStrategy = null): void
Constructor method for the Blueprint class.
- Parameters:
  - `$table`: String The name of the table.
  - `$timestampsStrategy`: Optional. The timestamps strategy to use. Defaults to null.
- Throws:
  - `Exception`: If the database driver is unsupported.

### column(string $sql): void
Defines a column using raw SQL.
- Parameters:
  - `$sql`: String The SQL statement defining the column.

### raw(string $sql): void
Defines or updates a column using raw SQL.
- Parameters:
  - `$sql`: String The SQL statement defining or updating the column.

### foreign(string $column, string $table, string $references): void
Defines a foreign key constraint.
- Parameters:
  - `$column`: String The column to which the foreign key constraint will be added.
  - `$table`: String The table being referenced.
  - `$references`: String The column in the referenced table.

### timestamps(): void
Defines timestamps columns.

### getTimestampsStrategy(): TimestampsStrategyInterface
Gets the timestamps strategy based on the database driver.
- Returns: TimestampsStrategyInterface The timestamps strategy based on the database driver.
- Throws:
  - `Exception`: If the database driver is unsupported.
