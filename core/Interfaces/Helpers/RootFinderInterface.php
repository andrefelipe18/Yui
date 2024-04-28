<?php

declare(strict_types=1);

namespace Yui\Core\Interfaces\Helpers;

interface RootFinderInterface
{
    /**
     * @param string $directory
     * @return string
     */
    public static function findRootFolder(string $directory): string;
}
