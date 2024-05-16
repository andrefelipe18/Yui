<?php

declare(strict_types=1);

namespace Yui\Core\Helpers\Functions;

use Yui\Core\Console\ConsolePrintter;

function consolePrinter(): ConsolePrintter
{
	return new ConsolePrintter();
}