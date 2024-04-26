<?php

declare(strict_types=1);

namespace Yui\Interfaces\Helpers;

interface DotenvInterface
{
    /**
     * @param string $path
     * @return void
     */
    public static function load(string|null $path): void;

    /**
     * @param string $key
     * @return string
     */
    public static function get(string $key): string;

    /**
     * @return void
     */
    public static function unset(): void;
}