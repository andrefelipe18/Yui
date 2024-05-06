# RawBuilder Class
`namespace: Yui\Core\Database\Builders`

Class responsible
for building SQL raw queries.

## Methods

### raw(string $sql, array $params = [], ?PDO $testingConnection = null): array
Executes a raw SQL query.
- Parameters:
  - `$sql`: The SQL query to be executed.
  - `$params`: The parameters to be used in the query.
  - `$testingConnection`: The connection to be used in the query in test mode.
- Returns: Array The result of the query.

