<?php

declare(strict_types=1);

namespace Yui\Core\Database\Migrations;

use PDO;
use Yui\Core\Console\ConsolePrintter;
use Yui\Core\Database\Connection;
use Yui\Core\Database\DB;
use Yui\Core\Helpers\Dotenv;

class MigrationRunner
{
    /**
     * Run the migrations
     * @throws \Exception if no migrations are found
     * @return void
     */
    public static function run(): void
    {
        if (!self::migrationsTableExists()) {
            self::createMigrationsTable();
        }

        $migrations = glob('app/Database/Migrations/*.php');

        if(!$migrations) {
            throw new \Exception("No migrations found");
        }

        foreach ($migrations as $migration) {
            if (self::hasRun($migration)) {
                continue;
            }

            (new ConsolePrintter())->text("\nRunning migration")
            ->text(basename($migration), 'yellow')
            ->print();
            $migrationInstance = include $migration;
            $migrationInstance->up();
            (new ConsolePrintter())->text("OK", 'black', 'green')->print();

            self::markAsRun($migration);
        }
    }

    /**
     * Rollback the migrations
     * @throws \Exception if no migrations are found
     * @return void
     */
    public static function rollback(): void
    {
        if (!self::migrationsTableExists()) {
            echo "Migrations table does not exist.\n";
            return;
        }

        $migrations = glob('app/Database/Migrations/*.php');

        if(!$migrations) {
            (new ConsolePrintter())->error("No migrations found")->print();
            throw new \Exception("No migrations found");
        }

        $migrations = array_reverse($migrations);

        foreach ($migrations as $migration) {
            if (!self::hasRun($migration)) {
                continue;
            }

            (new ConsolePrintter())->text("\nRolling back migration")
            ->text(basename($migration), 'yellow')
            ->print();
            $migrationInstance = include $migration;
            $migrationInstance->down();
            (new ConsolePrintter())->text("OK", 'black', 'green')->print();

            self::markAsRolledBack($migration);
        }
    }

    /**
     * Verify if a migration has been run
     * @param string $migration
     * @return bool
     */
    private static function hasRun(string $migration): bool
    {
        $migrationName = basename($migration);

        $result = DB::table('migrations')
            ->select('migrate')
            ->where('migrate', '=', $migrationName)
            ->andWhere('state', '=', 'up')
            ->get();

        if(is_string($result)) {
            return false;
        }

        return count($result) > 0 ? true : false;
    }

    /**
     * Mark the state of a migration
     * @param string $migration
     * @param string $state
     * @return void
     */
    private static function markMigrationState(string $migration, string $state): void
    {
        DB::table('migrations')->upsert([
            'migrate' => basename($migration),
            'state' => $state,
            'created_at' => date('Y-m-d H:i:s'),
        ], ['migrate'], ['state']);
    }

    /**
     * Mark a migration as run
     * @param string $migration
     * @return void
     */
    private static function markAsRun(string $migration): void
    {
        self::markMigrationState($migration, 'up');
    }

    /**
     * Mark a migration as rolled back
     * @param string $migration
     * @return void
     */
    private static function markAsRolledBack(string $migration): void
    {
        self::markMigrationState($migration, 'down');
    }

    /**
     * Verify if the migrations table exists
     * @return bool
     */
    private static function migrationsTableExists(): bool
    {
        Dotenv::load();
        $driver = Dotenv::get('DATABASE_CONNECTION');
        $conn = Connection::connect();

        switch ($driver) {
            case 'sqlite':
                $statement = $conn->prepare("SELECT name FROM sqlite_master WHERE type='table' AND name='migrations'");
                break;
            case 'mysql':
                $statement = $conn->prepare("SHOW TABLES LIKE 'migrations'");
                break;
            case 'pgsql':
                $statement = $conn->prepare("SELECT * FROM information_schema.tables WHERE table_name = 'migrations'");
                break;
            default:
                echo "Unsupported database driver\n";
                exit;
        }

        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC) !== false;
    }

    /**
     * Create the migrations table
     * @return void
     */
    private static function createMigrationsTable(): void
    {
        Dotenv::load();
        $driver = Dotenv::get('DATABASE_CONNECTION');
        if ($driver === 'sqlite' || $driver === 'mysql') {
            $sql = "CREATE TABLE migrations (
				id INT AUTO_INCREMENT PRIMARY KEY,
				migrate VARCHAR(255) NOT NULL,
				state VARCHAR(255) NOT NULL DEFAULT 'up',
				created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
			)";
        } elseif ($driver === 'pgsql') {
            $sql = "CREATE TABLE migrations (
				id SERIAL PRIMARY KEY,
				migrate VARCHAR(255) NOT NULL,
				state VARCHAR(255) NOT NULL DEFAULT 'up',
				created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
			)";
        } else {
            echo "Unsupported database driver\n";
            exit;
        }

        $conn = Connection::connect();

        $statement = $conn->prepare($sql);

        $statement->execute();
    }
}
