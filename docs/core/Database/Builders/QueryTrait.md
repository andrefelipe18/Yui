 # QueryTrait

`namespace: Yui\Core\Database\Builders`

## Introduction
The QueryTrait trait is responsible for providing methods to build SQL queries. It includes methods to retrieve the built SQL query string and the associated parameters.

## Properties

### $sql
- Type: string
- Description: The SQL query string representing the query.

### $params
- Type: array<int|string, mixed>
- Description: An array of parameters used in the SQL query.

## Methods

### getQuery(): string
Returns the built SQL query string.
- Returns: String The SQL query string.

### getParams(): array<int|string, mixed>
Returns the parameters used in the SQL query.
- Returns: Array An array of parameters.
