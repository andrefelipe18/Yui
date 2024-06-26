<?php

declare(strict_types=1);

namespace Yui\Core\Helpers;

use Exception;
use stdClass;
use Yui\Core\Interfaces\Helpers\DotenvInterface;

/**
 * This class is responsible for loading the .env file using singleton pattern
 * @package Yui\Helpers\Dotenv
 */
class Dotenv implements DotenvInterface
{
    /**
     * @var stdClass
     */
    protected static ?stdClass $dotenv = null;

    /**
     * @param string|null $path
     * @return void
     */
    public static function load(?string $path = ''): void
    {
        if (!static::$dotenv) {
            static::$dotenv = new stdClass();

            if ($path) {
                self::verifyFileExistence($path);
                self::processFile($path);
            } else {
                $path = RootFinder::findRootFolder(__DIR__) . '/.env';
                self::verifyFileExistence($path);
                self::processFile($path);
            }
        }
    }

    /**
     * @param string $path
     * @return void
     */
    private static function verifyFileExistence(string $path): void
    {
        if (!file_exists($path)) {
            throw new Exception('File not found');
        }
    }

    /**
     * @param string $path
     * @return void
     */
    private static function processFile(string $path): void
    {
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

    /**
     * @param string $key
     * @return string
     */
    public static function get(string $key): string|null
    {
        if (static::$dotenv) {
            if (property_exists(static::$dotenv, $key)) {
                return static::$dotenv->{$key};
            }

            return null;
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
