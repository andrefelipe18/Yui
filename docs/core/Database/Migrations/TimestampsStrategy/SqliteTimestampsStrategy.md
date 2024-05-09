# SqliteTimestampsStrategy Class

`namespace: Yui\Core\Database\Migrations\TimestampsStrategy`

This class provides methods to generate SQL queries for timestamps columns specifically for SQLite databases.

## Introduction

The SqliteTimestampsStrategy class implements the TimestampsStrategyInterface interface and defines methods to generate SQL queries for the `created_at` and `updated_at` columns in SQLite database tables.

## Methods

### getQueryCreatedAtColumn(): string

Generates the SQL query for the `created_at` column.

- Returns: String The SQL query for the `created_at` column.

### getQueryUpdatedAtColumn(): string

Generates the SQL query for the `updated_at` column.

- Returns: String The SQL query for the `updated_at` column.
