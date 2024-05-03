# SelectBuilder

`namespace: Yui\Core\Database\Builders`

## Introduction
The SelectBuilder class is responsible for building SQL select queries. It allows selecting specific columns to be retrieved from the database.

## Properties

### $columns
- Type: array<string>
- Description: An array of columns to be selected.

## Methods

### getQuery(): string
Returns the built SQL query string representing the selected columns.
- Returns: String The SQL query string.

### select(...$columns): SelectBuilder
Selects the columns to be retrieved from the database.
- Parameters:
  - `...$columns`: Variable number of column names.
- Returns: SelectBuilder The SelectBuilder instance.
