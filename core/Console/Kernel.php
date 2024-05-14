<?php

declare(strict_types=1);

namespace Yui\Core\Console;

class Kernel
{
	public array $arguments = [];
	public ConsolePrintter $printer;

	public function __construct(array $arguments)
	{
		$this->arguments = $arguments;
		$this->printer = new ConsolePrintter();
	}

	public function boot()
	{
		if (count($this->arguments) < 2) {
			$this->printer
				->text('Usage:', color: 'white')
				->text('  php yui [command]', color: 'white')
				->text('  php yui [command] [options]', color: 'white')
				->text('  php yui [command] [options] [arguments]', color: 'white')
				->print();


			$this->printer
				->breakLine()
				->error('No command provided.')
				->print();

			$this->printer
				->breakLine()
				->info('Available commands:')
				->print();

			$this->printer
				->breakLine()
				->success('Available commands:')
				->print();

			$this->printer
				->breakLine()
				->warning('Available commands:')
				->print();

			$this->printer
				->breakLine()
				->log('Available commands:')
				->print();
		}

		// self::registerCommands();
		// self::runCommand();
	}

	//Registrar os comandos
	public function registerCommands()
	{
	}

	//Executar o comando solicitado
	public function runCommand()
	{
	}
}
