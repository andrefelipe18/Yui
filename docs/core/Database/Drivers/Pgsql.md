# Pgsql Class

`namespace: Yui\Core\Database\Drivers`
This class provides a method to establish a connection to a PostgreSQL database using PDO.

## Introduction
The Pgsql class contains a static method `connect()` that creates a PDO connection to a PostgreSQL database with the provided connection parameters.

## Methods

### connect(string $host, string $dbname, string $user, string $pass, string $port, int $timeout = 30): PDO|PDOException
Creates a PDO connection to a PostgreSQL database.
- Parameters:
  - `$host`: The host of the PostgreSQL server.
  - `$dbname`: The name of the PostgreSQL database.
  - `$user`: The username for connecting to the PostgreSQL database.
  - `$pass`: The password for connecting to the PostgreSQL database.
  - `$port`: The port number of the PostgreSQL server.
  - `$timeout`: Optional. Connection timeout in seconds. Default is 30 seconds.
- Returns: PDO|PDOException The PDO database connection on success, or a PDOException on failure.
