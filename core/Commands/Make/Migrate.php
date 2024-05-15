<?php

declare(strict_types=1);

namespace  Yui\Core\Commands\Make;

use Yui\Core\Commands\Command;
use Yui\Core\Console\ConsolePrintter;
use Yui\Core\Helpers\StubParser;

class Migrate extends Command
{
    public string $name = 'migrate';
    public string $description = 'Create a new migration file';
    public string $usage = 'php yui make:migrate [name]';

    public function run(array $args = []): void
    {
        $name = $args[2] ?? '';

        if (empty($name)) {
            (new ConsolePrintter)
                ->error('Please provide a name for the migration file')
                ->breakLine()
                ->print();

            return;
        }

        if (!preg_match('/^[a-zA-Z0-9_]+$/', $name)) {
            (new ConsolePrintter)
                ->error('The migration name must contain only letters, numbers and underscores')
                ->breakLine()
                ->print();

            return;
        }

        $migrationFiles = glob('app/Database/Migrations/*.php');

        foreach ($migrationFiles as $migrationFile) {
            $migrationName = explode('_', basename($migrationFile));

            $migrationName = $migrationName[1] . '_' . $migrationName[2] . '_' . $migrationName[3];

            $migrationName = str_replace('.php', '', $migrationName);

            if ($migrationName === $name) {
                (new ConsolePrintter)
                    ->error('A migration with this name already exists')
                    ->breakLine()
                    ->print();

                return;
            }
        }

        $migrationCount = count(glob('app/Database/Migrations/*.php'));
        $migrationName = sprintf('%04d', $migrationCount + 1) . '_' . $name . '.php';

        $tableName = explode('_', $name)[1];
        $action = explode('_', $name)[0];

        if ($action === 'create') {
            $stubName = 'Migrations/Migration-Create';
        } else if ($action === 'alter') {
            $stubName = 'Migrations/Migration-Alter';
        } else {
            $stubName = "Migrations/Migration";
        }

        $stubParser = new StubParser();
        $stubParser->load($stubName);

        $stubParser->parse('$table', $tableName);

        $migrationContent = $stubParser->get();

        file_put_contents("app/Database/Migrations/{$migrationName}", $migrationContent);
    }
}
