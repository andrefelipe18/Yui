<?php

declare(strict_types=1);

namespace Yui\Core\Console;

class Kernel
{
    public array $arguments = [];
    private ConsolePrintter $printer;

    public function __construct(array $arguments)
    {
        $this->arguments = $arguments;
        $this->printer = new ConsolePrintter();
    }

    public function boot()
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

    private function buildCommandNamespace(string $namespace, string $commandName, string $commandAction): string
    {
        return $namespace . '\\' . $commandName . '\\' . $commandAction;
    }

    private function runCommand(string $commandNamespace): void
    {
        $commandInstance = new $commandNamespace();
        $commandInstance->run();
    }
}
