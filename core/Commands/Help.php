<?php

declare(strict_types=1);

namespace Yui\Core\Commands;

use Yui\Core\Console\ConsolePrintter;

/**
 * This class is responsible for showing all the available methods and their respective descriptions
 */
class Help extends Command
{
	public string $name = 'help';
	public string $description = 'Show all available commands';

	public function run()
	{
		$commands = glob('core/Commands/*/*.php');

		(new ConsolePrintter)->text("\nUsage: yui [command]")->print();
		(new ConsolePrintter)->text("Usage: yui [command] [arguments]")->print();
		(new ConsolePrintter)->text("Usage: yui [command] [arguments] [options]")->print();
		(new ConsolePrintter)->text("\n Available commands: ", 'black', 'yellow')->breakLine()->print();

		(new ConsolePrintter)->text("yui help", 'black', 'blue')->text("- Show all available commands")->breakLine()->print();

		foreach ($commands as $command) {
			$command = str_replace('core/Commands/', '', $command);
			$command = str_replace('.php', '', $command);
			$command = str_replace('/', ':', $command); // Alterado para substituir '/' por ':'

			if ($command === 'Command') {
				continue;
			}

			$commandClass = 'Yui\\Core\\Commands\\' . str_replace(':', '\\', $command);
			$commandInstance = new $commandClass();

			$description = $commandInstance->description;
			$command = strtolower($command);

			$commandParts = explode(':', $command);

			if($commandParts[0] === $commandParts[1]) {
				$command = $commandParts[0];
			}

			(new ConsolePrintter)->text("{$command}", 'black', 'blue')->text("- {$description}")->breakLine()->print();
		}
	}
}
