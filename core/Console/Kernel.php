<?php

declare(strict_types=1);

namespace Yui\Core\Console;

use Yui\Core\Commands\Command;

class Kernel
{
    /** @var array<string> */
    public array $arguments = [];
    private ConsolePrintter $printer;

    /**
     * Kernel constructor.
     * @param array<string> $arguments
     */
    public function __construct(array $arguments)
    {
        $this->arguments = $arguments;
        $this->printer = new ConsolePrintter();
    }

    /**
     * Function to boot the console
     * @return void
     */
    public function boot(): void
    {
        if (count($this->arguments) < 2 || $this->arguments[1] === 'help') {
            $this->runCommand('Yui\Core\Commands\Help');
            return;
        }

        $command = $this->arguments[1];
        $namespace = 'Yui\Core\Commands';
        $commandParts = explode(':', $command);

        try {
            $commandName = ucfirst($commandParts[0]);
            $commandAction = count($commandParts) > 1 ? ucfirst($commandParts[1]) : $commandName;
            $commandNamespace = $this->buildCommandNamespace($namespace, $commandName, $commandAction);
            $this->runCommand($commandNamespace);
        } catch (\Error $e) {
            $this->printer->text('Invalid command! Use yui help to see the available commands', 'red')->print();
        }
    }

    /**
     * Function to build the command namespace
     * @param string $namespace
     * @param string $commandName
     * @param string $commandAction
     * @return string
     */
    private function buildCommandNamespace(string $namespace, string $commandName, string $commandAction): string
    {
        return $namespace . '\\' . $commandName . '\\' . $commandAction;
    }

    /**
     * Function to run a command
     * @param string $commandNamespace
     * @return void
     */
    private function runCommand(string $commandNamespace): void
    {
        /** @var Command */
        $commandInstance = new $commandNamespace();
        $commandInstance->run($this->arguments);
    }
}
