<?php

declare(strict_types=1);

namespace Yui\Core\Database\Migrations;

use Yui\Core\Database\Connection;

class MigrationRunner
{
	private static array $avaliableMethods = [
		'alterTable',
		'raw',
	];

	public static function run()
	{
		$migrations = glob('app/Database/Migrations/*.php');

		foreach ($migrations as $migration) {
			$migrationInstance = include $migration;

			if ($migrationInstance->table == null) {
				throw new \Exception("Table name is required");
			}

			$migrationInstance->setColumns();

			if (!empty($migrationInstance->columns)) {
				$sql = $migrationInstance->create();
			} else {
				foreach (self::$avaliableMethods as $method) {
					if (method_exists($migrationInstance, $method)) {
						$sql = $migrationInstance->$method();
					}
				}
			}

			if (!empty($sql)) {
				$conn = Connection::connect();

				try {
					$conn->exec($sql);
				} catch (\PDOException $e) {
					echo $e->getMessage() . PHP_EOL;
					die();
				}
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
