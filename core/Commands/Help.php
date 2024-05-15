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

    /**
     * Function to run the help command
     * @param array<string> $args
     * @return void
     */
    public function run(array $args = []): void
    {
        $commands = glob('core/Commands/*/*.php');

        (new ConsolePrintter())->text("\nUsage: yui [command]")->print();
        (new ConsolePrintter())->text("Usage: yui [command] [arguments]")->print();
        (new ConsolePrintter())->text("Usage: yui [command] [arguments] [options]")->print();
        (new ConsolePrintter())->text("\n Available commands: ", 'black', 'yellow')->breakLine()->print();

        (new ConsolePrintter())->text("yui help", 'black', 'blue')->text("- Show all available commands")->breakLine()->print();

        if (!$commands) {
            return;
        }

        foreach ($commands as $command) {
            $command = str_replace('core/Commands/', '', $command);
            $command = str_replace('.php', '', $command);
            $command = str_replace('/', ':', $command);

            if ($command === 'Command') {
                continue;
            }

            $commandClass = 'Yui\\Core\\Commands\\' . str_replace(':', '\\', $command);
            /** @var Command $commandInstance */
            $commandInstance = new $commandClass();

            $description = $commandInstance->description;
            $usage = $commandInstance->usage;
            $command = strtolower($command);

            $commandParts = explode(':', $command);

            if ($commandParts[0] === $commandParts[1]) {
                $command = $commandParts[0];
            }

            (new ConsolePrintter())->text("{$command}", 'black', 'blue')
                ->text("`{$usage}`")
                ->text("- {$description}")->breakLine()->print();
        }
    }
}
