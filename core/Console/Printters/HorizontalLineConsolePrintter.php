<?php

declare(strict_types=1);

namespace Yui\Core\Console\Printters;

class HorizontalLineConsolePrintter extends Printter
{
	/**
	 * Make a horizontal line to be printed in the console.
	 * @return string The formatted message.
	 */
	public function horizontalLine(): string
	{
		return str_repeat('-', 80) . "\n";
	}
}