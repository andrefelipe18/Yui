<?php

declare(strict_types=1);

namespace Yui\Core\Commands\Migrate;

use Yui\Core\Commands\Command;
use Yui\Core\Database\Migrations\MigrationRunner;

class Rollback extends Command
{
    public string $name = 'rollback';
    public string $description = 'Rollback migrations';
    public string $usage = 'php yui migrate:rollback';

    public function run(array $args = []): void
    {
        MigrationRunner::rollback();
    }
}
