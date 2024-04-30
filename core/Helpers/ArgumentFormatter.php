<?php

declare(strict_types=1);

namespace Yui\Core\Helpers;

use Exception;
use stdClass;

class ArgumentFormatter
{
    /**
     * Formats the arguments into an object.
     *
     * @param array<mixed, mixed> $arguments The arguments to be formatted.
     * @return stdClass The object containing the formatted arguments.
     */
    public static function format(array $arguments): stdClass
    {
        if (!is_array($arguments)) {
            throw new Exception('The argument must be an array.');
        }

        if (empty($arguments)) {
            return new stdClass();
        }

        $formattedArguments = new stdClass();

        foreach ($arguments as $index => $argument) {
            if (is_array($argument) && self::isAssocArray($argument)) {
                // If the argument is an associative array, convert it to an object
                $formattedArguments->{$index} = (object) $argument;
            } else {
                // Else, just assign the argument to the object
                $formattedArguments->{$index} = $argument;
            }
        }

        return $formattedArguments;
    }

    /**
     * Checks if an array is associative.
     *
     * @param array<string, mixed> $array The array to be checked.
     * @return bool Returns true if the array is associative.
     */
    private static function isAssocArray(array $array)
    {
        if (empty($array)) {
            return false;
        }
        return array_keys($array) !== range(0, count($array) - 1);
    }
}
