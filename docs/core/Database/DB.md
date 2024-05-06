# DB Class

`namespace: Yui\Core\Database`
Class responsible for building SQL queries.

## Introduction
The DB class provides a static method to create a new instance of the QueryBuilder class, which is used for building SQL queries.

## Methods

### table(string $table): QueryBuilder
Creates a new instance of the QueryBuilder class with the specified table name.
- Parameters:
  - `$table`: String The name of the database table.
  - `$pdo`: PDO The PDO instance to be used for the query in test mode.
- Returns: QueryBuilder An instance of the QueryBuilder class.


### raw(string $sql, array $params = []): array
Executes a raw SQL query.
- Parameters:
  - `$sql`: String The SQL query to be executed.
  - `$params`: Array The parameters to be used in the query.