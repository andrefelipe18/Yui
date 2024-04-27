# Mysql Class

`namespace: Yui\Core\Database\Drivers`
This class provides a method to establish a connection to a MySQL database using PDO.

## Introduction
The Mysql class contains a static method `connect()` that creates a PDO connection to a MySQL database with the provided connection parameters.

## Methods

### connect(string $host, string $dbname, string $user, string $pass, string $port, int $timout = 30): PDO|PDOException
Creates a PDO connection to a MySQL database.
- Parameters:
  - `$host`: The host of the MySQL server.
  - `$dbname`: The name of the MySQL database.
  - `$user`: The username for connecting to the MySQL database.
  - `$pass`: The password for connecting to the MySQL database.
  - `$port`: The port number of the MySQL server.
  - `$timeout`: Optional. Connection timeout in seconds. Default is 30 seconds.
- Returns: PDO|PDOException The PDO database connection on success, or a PDOException on failure.
