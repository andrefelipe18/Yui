# Builder Class

`namespace: Yui\Core\Database\Builders`

## Introduction
The Builder class is an abstract base class for other database query builder classes. It provides common functionality and helper methods used by its subclasses.

## Methods

### validateNotEmpty(mixed $value, string $message): void
Validates that a value is not empty. If the value is empty, it throws an exception with the specified message.
- Parameters:
  - `$value`: Mixed The value to be validated.
  - `$message`: String The error message to be thrown if the value is empty.
- Returns: Void
