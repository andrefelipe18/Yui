# Connection Class

`namespace: Yui\Core\Database\`
This class handles database connections using PDO. It implements the singleton pattern to ensure that only one connection is established.

## Introduction
The Connection class provides methods to connect to various types of databases such as SQLite, MySQL, and PostgreSQL. It also handles loading database connection parameters from the `.env` file.

## Properties

### $pdo
- Type: PDO|null
- Description: Stores the PDO database connection.

## Methods

### connect(?string $pathToSqlite = null, ?string $envPath = '', int $timeout = 30): PDO|null
Establishes a database connection using PDO.
- Parameters:
  - `$pathToSqlite`: Optional. Path to the SQLite database file (required only for SQLite connections).
  - `$envPath`: Optional. Path to the `.env` file.
  - `$timeout`: Optional. Connection timeout in seconds.
- Returns: PDO|null The PDO database connection.
- Throws:
  - `Exception`: If database connection parameters are missing or unsupported, or if the connection fails.

### disconnect(): void
Ends the connection with the database.
- Returns: Void
