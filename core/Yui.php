<?php

declare(strict_types=1);

namespace Yui\Core;

use Yui\Core\Database\DatabaseInitializer;
use Yui\Core\Helpers\Dotenv;

class Yui
{
    /**
     * Get the version of the application.
     *
     * @return string
     */
    public static function version(): string
    {
        return '0.0.1';
    }

    /**
     * Boot the application.
     *
     * @return void
     */
    public static function boot(): void
    {
        echo "Booting the application...\n";

        DatabaseInitializer::init();
        Dotenv::load();

        echo "The application has been booted.\n";
    }
}
