# SqliteDatabaseInitializer Class

`namespace: Yui\Core\Database\Initializers`
Initializes Sqlite database.

## Introduction
This class is responsible for initializing Sqlite databases. It creates a PDO connection, checks if the specified database exists, creates it if it doesn't, and creates the necessary tables.

## Methods

### initialize(array $config): void
Initialize the Sqlite database.
- Parameters:
  - `$config`: Database connection configuration.
- Returns: Void

### getDriver(): string
Get the driver type for the Sqlite database connection.
- Returns: String Database driver type.

### getCreateTableQuery(): string
Get the SQL query to create the users table in Sqlite.
- Returns: String SQL query.

### createDatabaseAndTable(PDO $conn, string $dbName, string $createTableQuery)
Creates the database and table if they don't exist.
- Parameters:
  - `$conn`: PDO database connection.
  - `$dbName`: Database name.
  - `$createTableQuery`: SQL query to create the table.
- Returns: Void

### Usage
```php

use Yui\Core\Database\Initializers\DatabaseInitializer;

DatabaseInitializer::initialize('/path/to/database.sqlite');

```