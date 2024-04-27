# DatabaseInitializer Class

`namespace: Yui\Core\Database\Initializers`
Base class for database initializers.

## Introduction
This class provides a base for initializing databases in different database management systems (DBMS) such as MySQL, PostgreSQL, and SQLite. It allows for the creation of database connections, creation of databases and tables, and initialization of the database.

## Dependency Injection
Instead of creating the PDO connection directly in child classes, you could pass it as a dependency. This would make your code more testable and flexible.

## Methods

### init(array $config = null)
Initializes the database based on the provided configuration.
- Parameters:
  - `$config`: An array containing database connection configuration (optional). If not provided, configuration is fetched from environment variables.
- Returns: Void
- Throws:
  - `Exception`: If database connection type is not set in the `.env` file or if the database connection type is not supported.

### createConnection(array $config, ?string $dbName = null): PDO
Creates a PDO connection based on configuration.
- Parameters:
  - `$config`: Database connection configuration.
  - `$dbName`: Optional database name.
- Returns: PDO database connection.
- Throws:
  - `Exception`: If the database driver is not supported.

### createDatabaseAndTable(PDO $conn, string $dbName, string $createTableQuery)
Creates the database and table if they don't exist.
- Parameters:
  - `$conn`: PDO database connection.
  - `$dbName`: Database name.
  - `$createTableQuery`: SQL query to create the table.
- Returns: Void

### getDriver(): string
Get the driver type for the database connection.
- Returns: String Database driver type.

### getCreateTableQuery(): string
Get the SQL query to create the database table.
- Returns: String SQL query.
