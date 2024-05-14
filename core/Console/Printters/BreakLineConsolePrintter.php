<?php

declare(strict_types=1);

namespace Yui\Core\Console\Printters;

class BreakLineConsolePrintter extends Printter
{
	/**
	 * Make a break line to be printed in the console.
	 * @return string The formatted message.
	 */
	public function breakLine(): string
	{
		return "\n";
	}
}