# Schema Class

`namespace: Yui\Core\Database\Migrations`

This class provides static methods for creating, updating, dropping tables, and executing raw SQL queries.

## Introduction

The Schema class simplifies database schema management by providing methods for table creation, alteration, and deletion.

## Methods

### create(string $table, callable $callback): void

Creates a new table using a callback to define the table schema.

- Parameters:
  - `$table`: String The name of the table to be created.
  - `$callback`: Callable A callback function used to define the table schema using a Blueprint instance.

### table(string $table, callable $callback): void

Updates an existing table using a callback to define the changes.

- Parameters:
  - `$table`: String The name of the table to be updated.
  - `$callback`: Callable A callback function used to define the changes to the table schema using a Blueprint instance.

### raw(string $sql): void

Executes a raw SQL query.

- Parameters:
  - `$sql`: String The raw SQL query to be executed.

### dropIfExists(string $table): void

Drops a table if it exists.

- Parameters:
  - `$table`: String The name of the table to be dropped.

### executeQuery(string $sql): void

Executes a SQL query.

- Parameters:
  - `$sql`: String The SQL query to be executed.

