<?php

declare(strict_types=1);

namespace Yui\Core\Console\Printters;

/**
 * This class is responsible for creating a line of text to be printed on the console
 * @package Yui\Core\Console\Printters
 */
class TextConsolePrintter extends Printter
{
    /**
     * Make a text message to be printed in the console.
     * @param string $text The text to be printed.
     * @param string|null $color The color of the text.
     * @param string|null $backgroundColor The background color of the text.
     * @return string The formatted message.
     */
    public function text(string $text, ?string $color = null, ?string $backgroundColor = null): string
    {
        return $this->formatMessage($text, $color, $backgroundColor);
    }
}
