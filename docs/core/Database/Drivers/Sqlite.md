# Sqlite Class

`namespace: Yui\Core\Database\Drivers`
This class provides a method to establish a connection to a SQLite database using PDO.

## Introduction
The Sqlite class contains a static method `connect()` that creates a PDO connection to a SQLite database with the provided path.

## Methods

### connect(string $path): PDO
Creates a PDO connection to a SQLite database.
- Parameters:
  - `$path`: The path to the SQLite database file.
- Returns: PDO The PDO database connection on success, or a PDOException on failure.
