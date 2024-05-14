<?php

declare(strict_types=1);

namespace Yui\Core\Console\Printters;

/**
 * This class is responsible for creating a success message to be printed on the console
 * @package Yui\Core\Console\Printters
 */
class SuccessConsolePrintter extends Printter
{
    /**
     * Make a success message to be printed in the console.
     * @param string $text The text to be printed.
     * @return string The formatted error message.
     */
    public function success(string $message): void
    {
        /**
         * SUCCESS in background green and bold, with text in white.
         * \n\n for two line breaks.
         * Message in white.
         */
        echo "\033[1;30;42;1m SUCCESS \033[0m\n\n\033[1;37m{$message}\033[0m\n";

        // Reset the color
        echo "\033[0m";
    }
}
