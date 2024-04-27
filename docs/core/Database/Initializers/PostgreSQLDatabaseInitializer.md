# PostgreSQLDatabaseInitializer Class

`namespace: Yui\Core\Database\Initializers`
Initializes PostgreSQL database.

## Introduction
This class is responsible for initializing PostgreSQL databases. It creates a PDO connection, checks if the specified database exists, creates it if it doesn't, and creates the necessary tables.

## Methods

### initialize(array $config): void
Initialize the PostgreSQL database.
- Parameters:
  - `$config`: Database connection configuration.
- Returns: Void

### getDriver(): string
Get the driver type for the PostgreSQL database connection.
- Returns: String Database driver type.

### getCreateTableQuery(): string
Get the SQL query to create the users table in PostgreSQL.
- Returns: String SQL query.

### createDatabaseAndTable(PDO $conn, string $dbName, string $createTableQuery)
Creates the database and table if they don't exist.
- Parameters:
  - `$conn`: PDO database connection.
  - `$dbName`: Database name.
  - `$createTableQuery`: SQL query to create the table.
- Returns: Void
