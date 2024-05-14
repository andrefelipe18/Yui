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

	abstract public function run();
}