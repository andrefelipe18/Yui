<?php

declare(strict_types=1);

namespace Yui\Core\Helpers;

use Exception;
use Yui\Core\Interfaces\Helpers\RootFinderInterface;

class RootFinder implements RootFinderInterface
{
    /**
     * Recursively finds the root folder of the project.
     *
     * @param string $directory
     * @return string
     * @throws Exception
     */
    public static function findRootFolder(string $directory): string
    {
        if (file_exists($directory . '/.env')) {
            return $directory;
        }

        $parentDirectory = dirname($directory);

        if ($parentDirectory === $directory) {
            throw new Exception('.env file not found in the project structure.');
        }

        return self::findRootFolder($parentDirectory);
    }
}
