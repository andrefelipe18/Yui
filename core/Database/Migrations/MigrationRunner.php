<?php

declare(strict_types=1);

namespace Yui\Core\Database\Migrations;

use PDO;
use Yui\Core\Database\Connection;
use Yui\Core\Database\DB;

class MigrationRunner
{
	private static function hasRun(string $migration)
	{
		$migrationName = basename($migration);

		$result = DB::table('migrations')
			->select('migrate')
			->where('migrate', '=', $migrationName)
			->get();

		return count($result) > 0 ? true : false;
	}

	private static function markAsRun(string $migration): void
	{
		DB::table('migrations')->insert([
			'migrate' => basename($migration),
			'created_at' => date('Y-m-d H:i:s'),
		]);
	}

	public static function run(): void
	{
		if (!self::migrationsTableExists()) {
			self::createMigrationsTable();
		}

		$migrations = glob('app/Database/Migrations/*.php');

		foreach ($migrations as $migration) {
			if (self::hasRun($migration)) {
				continue;
			}

			echo "Running migration {$migration}..." . PHP_EOL;
			$migrationInstance = include $migration;
			$migrationInstance->up();
			echo "OK" . PHP_EOL;

			self::markAsRun($migration);
		}
	}

	private static function migrationsTableExists(): bool
	{
		$conn = Connection::connect();

		$statement = $conn->prepare("SHOW TABLES LIKE 'migrations'");

		$statement->execute();

		$result = $statement->fetch(PDO::FETCH_ASSOC);

		return $result ? true : false;
	}

	private static function createMigrationsTable(): void
	{
		$sql = "CREATE TABLE migrations (
			id INT AUTO_INCREMENT PRIMARY KEY,
			migrate VARCHAR(255) NOT NULL,
			created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
		)";

		$conn = Connection::connect();

		$statement = $conn->prepare($sql);

		$statement->execute();
	}

	public static function rollback()
	{
		$migrations = glob('app/Database/Migrations/*.php');

		foreach ($migrations as $migration) {
			echo basename($migration) . PHP_EOL;

			if (basename($migration) === '0000_create_core_tables.php') {
				continue;
			}

			if (basename($migration) !== '0000_create_core_tables.php') {
				echo "Running migration: $migration\n";
				if (self::hasRun($migration)) {
					continue;
				}
			}

			$migrationInstance = include $migration;
			$migrationInstance->down();

			self::markAsRun($migration);
		}
	}
}
