# Connection Class

`namespace: Yui\Core\Database`
This class is responsible for connecting to the database using PDO. It implements the singleton pattern to ensure that only one connection is made.

## Introduction
The Connection class provides methods to connect to different types of databases (SQLite, MySQL, PostgreSQL) using PDO. It loads database connection parameters from a .env file using the Dotenv class.

## Properties

### $pdo
- Type: PDO|null
- Description: Stores the PDO database connection.

## Methods

### connect(?string $pathToSqlite = null, ?string $envPath = '', ?int $timeout = 30): PDO|null
Establishes a connection to the database using PDO.
- Parameters:
  - `$pathToSqlite`: Optional. Path to the SQLite file. Required if the database connection type is SQLite.
  - `$envPath`: Optional. Path to the .env file. If not provided, it defaults to an empty string.
  - `$timeout`: Optional. Connection timeout in seconds. Default is 30 seconds.
- Returns: PDO The PDO database connection
- Throws:
  - `Exception`: If database connection parameters are not set in the .env file, or if there's an error connecting to the database.

### connectMysqlOrPgsql(string $driver, int $timeout): PDO
Connects to a MySQL or PostgreSQL database using PDO.
- Parameters:
  - `$driver`: The database driver ('mysql' or 'pgsql').
  - `$timeout`: Connection timeout in seconds.
- Returns: PDO The PDO database connection on success.
- Throws:
  - `Exception`: If database connection parameters are not set in the .env file, or if there's an error connecting to the database.

### loadEnv(?string $envPath = ''): void
Loads the .env file.
- Parameters:
  - `$envPath`: Optional. Path to the .env file. If not provided, it defaults to an empty string.
- Returns: Void

### validateDriver(): string
Validates the database driver specified in the .env file.
- Returns: String The validated database driver ('sqlite', 'mysql', or 'pgsql').
- Throws:
  - `Exception`: If database connection type is not set in the .env file, or if it's not supported.

### connectSqlite(?string $pathToSqlite = null): PDO
Connects to a SQLite database using PDO.
- Parameters:
  - `$pathToSqlite`: Optional. Path to the SQLite file.
- Returns: PDO The PDO database connection on success.
- Throws:
  - `Exception`: If path to SQLite file is not set.

### disconnect(): void
Ends the connection with the database.
- Returns: Void
