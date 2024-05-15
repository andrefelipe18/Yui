<?php

declare(strict_types=1);

namespace Yui\Core\Console\Printters;

/**
 * This class is responsible for creating a info message to be printed on the console
 * @package Yui\Core\Console\Printters
 */
class InfoConsolePrintter extends Printter
{
    /**
     * Make a info message to be printed in the console.
     * @param string $message The text to be printed.
     * @return string The formatted error message.
     */
    public function info(string $message): string
    {
        /**
         * INFO in background blue and bold, with text in white.
         * \n\n for two line breaks.
         * Message in white.
         */
        return "\033[44;1m INFO \033[0m\n\n\033[1;37m{$message}\033[0m\n";
    }
}
