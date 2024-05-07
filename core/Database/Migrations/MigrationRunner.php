<?php

declare(strict_types=1);

namespace Yui\Core\Database\Migrations;

use PDO;
use Yui\Core\Database\Connection;

class MigrationRunner
{
	private static function hasRun(string $migration): bool
	{
		$conn = Connection::connect();
		$stmt = $conn->prepare("SELECT * FROM migrations_history WHERE name = :name");
		$stmt->execute([':name' => $migration]);

		return $stmt->fetch(PDO::FETCH_ASSOC) !== false;
	}

	private static function markAsRun(string $migration): void
	{
		$conn = Connection::connect();
		$stmt = $conn->prepare("INSERT INTO migrations_history (name) VALUES (:name)");
		$stmt->execute([':name' => $migration]);
	}

	public static function run(): void
	{
		$migrations = glob('app/Database/Migrations/*.php');

		foreach ($migrations as $migration) {
			echo basename($migration) . PHP_EOL;

			if(basename($migration) === '0000_create_core_tables.php') {
				$migrationInstance = include $migration;
				$migrationInstance->up();

				self::markAsRun($migration);
			}

			if (basename($migration) !== '0000_create_core_tables.php') {
				echo "Running migration: $migration\n";
				if(self::hasRun($migration)){
					continue;
				}
			}

			$migrationInstance = include $migration;
			$migrationInstance->up();

			self::markAsRun($migration);
		}
	}

	public function rollback()
	{
		$migrations = glob('app/Database/Migrations/*.php');

		foreach ($migrations as $migration) {
			echo basename($migration) . PHP_EOL;

			if(basename($migration) === '0000_create_core_tables.php') {
				$migrationInstance = include $migration;
				$migrationInstance->down();

				self::markAsRun($migration);
			}

			if (basename($migration) !== '0000_create_core_tables.php') {
				echo "Running migration: $migration\n";
				if(self::hasRun($migration)){
					continue;
				}
			}

			$migrationInstance = include $migration;
			$migrationInstance->down();

			self::markAsRun($migration);
		}
	}
}
