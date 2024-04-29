# PostgreSQLDatabaseInitializer Class

`namespace: Yui\Core\Database\Initializers`
Initializes PostgreSQL database.

## Introduction
This class is responsible for initializing PostgreSQL databases. It creates a PDO connection, checks if the specified database exists, creates it if it doesn't, and creates the necessary tables.

## Methods

### initialize(array $config): void
Initializes the PostgreSQL database.
- Parameters:
  - `$config`: Database connection configuration.
- Returns: Void

### getDriver(): string
Gets the driver type for the PostgreSQL database connection.
- Returns: String Database driver type.

### getCreateTableQuery(): string
Gets the SQL query to create the users table in PostgreSQL.
- Returns: String SQL query.

### createDatabase(PDO $conn, string $dbName): void
Creates the database if it doesn't exist.
- Parameters:
  - `$conn`: PDO database connection.
  - `$dbName`: Database name.
- Returns: Void

### createTable(PDO $conn, string $dbName, string $createTableQuery): void
Creates the users table if it doesn't exist.
- Parameters:
  - `$conn`: PDO database connection.
  - `$dbName`: Database name.
  - `$createTableQuery`: SQL query to create the users table.
- Returns: Void
