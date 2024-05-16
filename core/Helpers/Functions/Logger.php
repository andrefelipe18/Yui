<?php

declare(strict_types=1);

namespace Yui\Core\Helpers\Functions;

use Yui\Core\Log\Logger;

function logger(): Logger
{
	return new Logger();
}