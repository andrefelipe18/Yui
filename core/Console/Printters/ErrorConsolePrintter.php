<?php

declare(strict_types=1);

namespace Yui\Core\Console\Printters;

/**
 * This class is responsible for creating a error message to be printed on the console
 * @package Yui\Core\Console\Printters
 */
class ErrorConsolePrintter extends Printter
{
    /**
     * Make a error message to be printed in the console.
     * @param string $text The text to be printed.
     * @return string The formatted error message.
     */
    public function error(string $message): void
    {
        /**
         * ERROR in background red and bold, with text in white.
         * \n\n for two line breaks.
         * Message in white.
         */
        echo "\033[41;1m ERROR \033[0m\n\n\033[1;37m{$message}\033[0m\n";

        // Reset the colors to default.
        echo "\033[0m";
    }
}
