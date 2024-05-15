<?php

declare(strict_types=1);

namespace Yui\Core\Commands;

/**
 * Base class for all commands
 */
abstract class Command
{
    public string $name = '';
    public string $description = '';
    public string $usage = '';

    /**
     * Run the command
     * @param array<string> $args
     * @return void
     */
    abstract public function run(array $args = []): void;
}
