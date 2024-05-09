# MigrationRunner Class

`namespace: Yui\Core\Database\Migrations`

This class is responsible for running and rolling back database migrations.

## Introduction

The MigrationRunner class provides static methods to run migrations and rollback migrations.

## Methods

### run(): void

Runs all available migrations.

- Throws:
  - `Exception`: If no migrations are found.

### rollback(): void

Rolls back the last migration.

- Throws:
  - `Exception`: If no migrations are found.

### hasRun(string $migration): bool

Verifies if a migration has been run.

- Parameters:
  - `$migration`: String The name of the migration.
- Returns: Boolean True if the migration has been run, otherwise false.

### markMigrationState(string $migration, string $state): void

Marks the state of a migration.

- Parameters:
  - `$migration`: String The name of the migration.
  - `$state`: String The state to mark the migration as ('up' or 'down').

### markAsRun(string $migration): void

Marks a migration as run.

- Parameters:
  - `$migration`: String The name of the migration.

### markAsRolledBack(string $migration): void

Marks a migration as rolled back.

- Parameters:
  - `$migration`: String The name of the migration.

### migrationsTableExists(): bool

Verifies if the migrations table exists in the database.

- Returns: Boolean True if the migrations table exists, otherwise false.

### createMigrationsTable(): void

Creates the migrations table in the database if it does not exist.

