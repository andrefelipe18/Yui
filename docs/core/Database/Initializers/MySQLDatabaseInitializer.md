# MySQLDatabaseInitializer Class

`namespace: Yui\Core\Database\Initializers`
Initializes MySQL database.

## Introduction
The MySQLDatabaseInitializer class is responsible for initializing a MySQL database. It extends the Initializer class and implements methods to create a new database and establish a connection to the MySQL server.

## Methods

### run(array $config): void
Runs the initializer.
- Parameters:
  - `$config`: Database connection configuration array.
- Returns: Void
- Throws: None

### createDatabase(PDO $conn, string $dbName): void
Creates a new database.
- Parameters:
  - `$conn`: PDO The PDO database connection.
  - `$dbName`: String The name of the database to be created.
- Returns: Void
- Throws: None

### createConnection(array $config, ?string $dbName = ''): PDO
Creates a new connection to the MySQL server.
- Parameters:
  - `$config`: Database connection configuration array.
  - `$dbName`: Optional. Name of the database to connect to. Default is an empty string.
- Returns: PDO The PDO database connection.
- Throws: None
