<?php

namespace Yui\Core\Console\Printters;

/**
 * The base class for all console printters.
 * @package Yui\Core\Console\Printters
 */
abstract class Printter
{
    protected const TEXT_COLORS = [
        'black' => '0;30',
        'dark_grey' => '1;30',
        'red' => '0;31',
        'light_red' => '1;31',
        'green' => '0;32',
        'light_green' => '1;32',
        'brown' => '0;33',
        'yellow' => '1;33',
        'blue' => '0;34',
        'light_blue' => '1;34',
        'magenta' => '0;35',
        'light_magenta' => '1;35',
        'cyan' => '0;36',
        'light_cyan' => '1;36',
        'white' => '1;37',
        'light_grey' => '0;37',
    ];

    protected const BACKGROUND_COLORS = [
        'black' => '40',
        'red' => '41',
        'green' => '42',
        'yellow' => '43',
        'blue' => '44',
        'magenta' => '45',
        'cyan' => '46',
        'light_grey' => '47',
    ];

    /**
     * Check if a color exists.
     * @param string $color The color to check.
     * @param bool $isBackground Whether the color is a background color.
     * @return bool True if the color exists, false otherwise.
     */
    protected function colorExists(string $color, bool $isBackground = false): bool
    {
        return array_key_exists($color, $isBackground ? self::BACKGROUND_COLORS : self::TEXT_COLORS);
    }

    /**
     * Format a message to be printed in the console.
     * @param string $text The text to be printed.
     * @param string|null $color The color of the text.
     * @param string|null $backgroundColor The background color of the text.
     * @param bool $isTitle Whether the text is a title.
     * @return string The formatted message.
     */
    protected function formatMessage(string $text, ?string $color, ?string $backgroundColor, bool $isTitle = false): string
    {
        $colorCode = $color && $this->colorExists($color) ? self::TEXT_COLORS[$color] : null;
        $backgroundColorCode = $backgroundColor && $this->colorExists($backgroundColor, true) ? self::BACKGROUND_COLORS[$backgroundColor] : null;

        $style = "\033[";

        if ($colorCode) {
            $style .= $colorCode;
        }

        if ($backgroundColorCode) {
            $style .= ';' . $backgroundColorCode;
        }

        if ($isTitle) {
            $style .= ';1';
        }

        $style .= "m{$text}\033[0m\n";

        return $style;
    }
}
