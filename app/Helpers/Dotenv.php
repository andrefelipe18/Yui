<?php

declare(strict_types=1);

namespace Yui\Helpers;

use Exception;
use stdClass;
use Yui\Interfaces\Helpers\DotenvInterface;

/**
 * This class is responsible for loading the .env file using singleton pattern
 * @package Yui\Helpers\Dotenv
 * @property private static stdClass $dotenv
 * @method static load()
 
 */
abstract class Dotenv implements DotenvInterface
{
    /**
     * @var stdClass
     */
    private static stdClass|null $dotenv = null;

    /**
     * @param string $path
     * @return void
     */
    public static function load(string|null $path = ''): void
    {
        if (!static::$dotenv) {
            static::$dotenv = new stdClass();

            if ($path) {
                if (!file_exists($path)) {
                    throw new Exception('File not found');
                }

                $file = file_get_contents($path);

                if ($file === false) {
                    throw new Exception('Error reading file');
                }

                $lines = explode("\n", $file);

                foreach ($lines as $line) {
                    if (strpos($line, '=') !== false) {
                        $line = explode('=', $line);
                        static::$dotenv->{$line[0]} = $line[1];
                    }
                }
            } else {
                $path = RootFinder::findRootFolder(__DIR__) . '/.env';

                if (!file_exists($path)) {
                    throw new Exception('File not found');
                }

                $file = file_get_contents($path);

                if ($file === false) {
                    throw new Exception('Error reading file');
                }

                $lines = explode("\n", $file);

                foreach ($lines as $line) {
                    if (strpos($line, '=') !== false) {
                        $line = explode('=', $line);
                        static::$dotenv->{$line[0]} = $line[1];
                    }
                }
            }
        }
    }

    /**
     * @param string $key
     * @return string
     */
    public static function get(string $key): string
    {
        if (static::$dotenv) {
            if (property_exists(static::$dotenv, $key)) {
                return static::$dotenv->{$key};
            }

            throw new Exception('Key not found');
        }

        throw new Exception('Dotenv not loaded');
    }

    /**
     * @return void
     */
    public static function unset(): void
    {
        static::$dotenv = null;
    }
}
