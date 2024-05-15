<?php

declare(strict_types=1);

namespace Yui\Core\Commands\Db;

use Yui\Core\Commands\Command;
use Yui\Core\Database\Seeders\SeedRunner;

class Seed extends Command
{
    public string $name = 'seed';
    public string $description = 'Seed the database';
    public string $usage = 'php yui db:seed';

    public function run(array $args = []): void
    {
        SeedRunner::run();
    }
}
