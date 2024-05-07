<?php

declare(strict_types=1);

namespace Yui\Core\Database;

class MigrationRunner
{
	private static array $avaliableMethods = [
		'alterTable',
		'dropColumn',
		'renameColumn',
		'renameTable',
		'raw',
	];

	public static function run()
	{
		$migrations = glob('app/Database/Migrations/*.php');

		foreach ($migrations as $migration) {
			echo "Running migration: $migration" . PHP_EOL;
			$migrationInstance = include $migration;

			try {
				//If the migration has a setColumns method, we will call it and create the table
				if (method_exists($migrationInstance, 'setColumns')) {
					echo "Creating table" . PHP_EOL;
					$migrationInstance->setColumns();
					$sql = $migrationInstance->create();
				} else { //If not, we will loop through the available methods and run the one that exists
					foreach (self::$avaliableMethods as $method) {
						if (method_exists($migrationInstance, $method)) {
							$sql = $migrationInstance->$method();
						}
					}
				}
			} catch (\Exception $e) {
				echo $e->getMessage() . PHP_EOL;
				die();
			}

			$conn = Connection::connect();

			try {
				$conn->exec($sql);
			} catch (\PDOException $e) {
				echo $e->getMessage() . PHP_EOL;
				die();
			}
		}
	}

	public function rollback()
	{
		$migrations = glob('app/Database/Migrations/*.php');

		foreach ($migrations as $migration) {
			require_once $migration;

			$className = basename($migration, '.php');

			$className = "App\\Database\\Migrations\\$className";

			$migration = new $className;

			$migration->rollback();
		}
	}
}
