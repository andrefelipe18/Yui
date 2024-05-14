<?php

declare(strict_types=1);

namespace Yui\Core\Console;

class Kernel
{
	public array $arguments = [];

	public function __construct(array $arguments)
	{
		$this->arguments = $arguments;
	}

	public function boot()
	{
		if (count($this->arguments) < 2) {
			(new ConsolePrintter)
				->title(' Yui Console ', color: 'black', backgroundColor: 'cyan')
				->breakLine()
				->text('Welcome to Yui Console', color: 'white')
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
