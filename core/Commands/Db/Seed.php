<?php

declare(strict_types=1);

namespace Yui\Core\Commands\Db;

use Yui\Core\Commands\Command;
use Yui\Core\Database\Seeders\SeedRunner;

class Seed extends Command
{
	public string $name = 'seed';
	public string $description = 'Seed the database';

	public function run()
	{
		SeedRunner::run();
	}
}