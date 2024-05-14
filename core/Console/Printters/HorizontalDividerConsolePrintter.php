<?php

declare(strict_types=1);

namespace Yui\Core\Console\Printters;

class HorizontalDividerConsolePrintter extends Printter
{
    /**
     * Make a horizontal Divider to be printed in the console.
     * @return string The formatted message.
     */
    public function horizontalLine(): string
    {
        return str_repeat('-', 80) . "\n";
    }
}
