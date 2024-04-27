# Dotenv Class

`namespace: Yui\Core\Helpers`
This class is responsible for loading the .env file using the singleton pattern.

## Introduction
The Dotenv class provides functionality to load and access environment variables from a .env file. It implements the singleton pattern to ensure that the .env file is loaded only once during the application's lifecycle.

## Properties

### $dotenv
- Type: stdClass|null
- Description: Stores the loaded environment variables.

## Methods

### load(string|null $path = '')
Loads the .env file and parses its contents to populate the `$dotenv` property.
- Parameters:
  - `$path`: Optional. Path to the .env file. If not provided, it defaults to the project root folder.
- Returns: Void
- Throws:
  - `Exception`: If the file is not found or an error occurs while reading the file.

### get(string $key): string|null
Retrieves the value of the specified environment variable.
- Parameters:
  - `$key`: The name of the environment variable.
- Returns: String|null The value of the environment variable, or null if not found.
- Throws:
  - `Exception`: If the Dotenv class has not been loaded.

### unset(): void
Resets the `$dotenv` property to null, effectively unloading the environment variables.
- Returns: Void
