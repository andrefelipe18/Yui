<?php

declare(strict_types=1);

namespace Yui\Core\Commands\Migrate;

use Yui\Core\Commands\Command;
use Yui\Core\Database\Migrations\MigrationRunner;

class Migrate extends Command
{
    public string $name = 'migrate';
    public string $description = 'Run all pending migrations';
    public string $usage = 'php yui migrate';

    public function run(array $args = []): void
    {
        MigrationRunner::run();
    }
}
