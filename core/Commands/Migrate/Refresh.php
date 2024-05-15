<?php

declare(strict_types=1);

namespace Yui\Core\Commands\Migrate;

use Yui\Core\Commands\Command;
use Yui\Core\Database\Migrations\MigrationRunner;

class Refresh extends Command
{
    public string $name = 'refresh';
    public string $description = 'Refresh migrations';
    public string $usage = 'php yui migrate:refresh';

    public function run(array $args = []): void
    {
        MigrationRunner::rollback();
        MigrationRunner::run();
    }
}
