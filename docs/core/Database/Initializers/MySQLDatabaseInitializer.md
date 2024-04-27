# MySQLDatabaseInitializer Class

`namespace: Yui\Core\Database\Initializers`
Initializes MySQL database.

## Introduction
This class is responsible for initializing MySQL databases. It creates a PDO connection, checks if the specified database exists, creates it if it doesn't, and creates the necessary tables.

## Methods

### initialize(array $config)
Initialize the MySQL database.
- Parameters:
  - `$config`: Database connection configuration.
- Returns: Void

### getDriver(): string
Get the driver type for the MySQL database connection.
- Returns: String Database driver type.

### getCreateTableQuery(): string
Get the SQL query to create the users table in MySQL.
- Returns: String SQL query.
