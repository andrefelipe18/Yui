<?php

declare(strict_types=1);

namespace Yui\Helpers;

use Exception;
use stdClass;
use Yui\Interfaces\Helpers\DotenvInterface;
use Yui\Helpers\Dotenv\DotenvData;

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
    public static function load(): void
    {
        try{
            if(!static::$dotenv){
                static::$dotenv = new stdClass();

                // Get the path to the .env file
                $path = __DIR__ . '/../../.env';
                // Get the contents of the .env file
                $file = file_get_contents($path);
                // Split the contents of the .env file by new line
                $lines = explode("\n", $file);

                // Loop through each line of the .env file
                foreach ($lines as $line) {
                    if (strpos($line, '=') !== false) {
                        $line = explode('=', $line);
                        static::$dotenv->{$line[0]} = $line[1];
                    }
                }
            }
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }
    }

    /**
     * @param string $key
     * @return string
     */
    public static function get(string $key): string
    {
        if (static::$dotenv) {
            return static::$dotenv->{$key};
        }

        return '';
    }
}
