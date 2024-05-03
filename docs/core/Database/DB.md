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
- Returns: QueryBuilder An instance of the QueryBuilder class.
