# RootFinder Class

`namespace: Yui\Core\Helpers`
This class is responsible for recursively finding the root folder of the project.

## Introduction
The RootFinder class provides a method to search for the root folder of the project by recursively checking parent directories until it finds a directory containing a `.env` file.

## Methods

### findRootFolder(string $directory): string
Recursively finds the root folder of the project.
- Parameters:
  - `$directory`: The directory path to start the search from.
- Returns: String The path to the root folder of the project.
- Throws:
  - `Exception`: If the `.env` file is not found in the project structure.
