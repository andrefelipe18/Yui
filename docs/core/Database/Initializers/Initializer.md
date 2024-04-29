# Initializer Class

`namespace: Yui\Core\Database\Initializers`
Abstract class for database initializers.

## Introduction
The Initializer class defines abstract methods to run the initializer, create a new database, and create a new connection. It serves as a base class for concrete database initializer classes such as MySQLDatabaseInitializer and PostgreSQLDatabaseInitializer.

## Methods

### run(array $config): void
Abstract method to run the initializer.
- Parameters:
  - `$config`: Database connection configuration.
- Returns: Void

### createDatabase(PDO $conn, string $dbName): void
Abstract method to create a new database.
- Parameters:
  - `$conn`: PDO The PDO database connection.
  - `$dbName`: String The name of the database to be created.
- Returns: Void

### createConnection(array $config, ?string $dbName = ''): PDO
Abstract method to create a new connection.
- Parameters:
  - `$config`: Database connection configuration array.
  - `$dbName`: Optional. Name of the database to connect to. Default is an empty string.
- Returns: PDO The PDO database connection.
