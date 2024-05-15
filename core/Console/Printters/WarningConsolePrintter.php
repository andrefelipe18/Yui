<?php

declare(strict_types=1);

namespace Yui\Core\Console\Printters;

/**
 * This class is responsible for creating a warning message to be printed on the console
 * @package Yui\Core\Console\Printters
 */
class WarningConsolePrintter extends Printter
{
    /**
     * Make a info message to be printed in the console.
     * @param string $message The text to be printed.
     * @return string The formatted error message.
     */
    public function warning(string $message): string
    {
        /**
         * WARNING in background yellow and bold with text in black.
         * \n\n for two line breaks.
         *
         * Message in white.
         */
        return "\033[30;43;1m WARNING \033[0m\n\n{$message}\033[0m\n";
    }
}
