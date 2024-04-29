# DatabaseInitializer Class

`namespace: Yui\Core\Database`
Base class for database initializers.

## Introduction
The DatabaseInitializer class provides methods to initialize the database connection based on the database driver specified in the .env file. It supports MySQL and PostgreSQL database drivers.

## Properties

### $driver
- Type: string
- Description: Stores the database driver specified in the .env file.

## Methods

### init(array $config = null, ?string $envPath = null): void
Initializes the database connection.
- Parameters:
  - `$config`: Optional. Database connection configuration. If not provided, it reads from the .env file.
  - `$envPath`: Optional. Path to the .env file.
- Returns: Void
- Throws:
  - `Exception`: If database connection parameters are not set in the .env file, or if there's an error initializing the database.

### createInitializer(): MySQLDatabaseInitializer|PostgreSQLDatabaseInitializer
Creates the database initializer based on the database driver specified in the .env file.
- Returns: MySQLDatabaseInitializer or PostgreSQLDatabaseInitializer
- Throws: None

### loadEnv(?string $envPath): void
Loads the environment variables from the .env file.
- Parameters:
  - `$envPath`: Optional. Path to the .env file.
- Returns: Void
- Throws: None

### setDriver(): void
Sets the database driver based on the value specified in the .env file.
- Returns: Void
- Throws:
  - `Exception`: If the database driver is not set or is not supported in the .env file.

### checkDriver(): void
Checks if the database driver is set and supported.
- Returns: Void
- Throws:
  - `Exception`: If the database driver is not set or is not supported in the .env file.

### getConnectionConfig(): array<string, string>
Returns the database connection configuration array.
- Returns: Array The database connection configuration array.
- Throws:
  - `Exception`: If database connection parameters are not set in the .env file.
