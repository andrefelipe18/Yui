<?php

declare(strict_types=1);

namespace Yui\Core\Database\Seeders;

/**
 * Class SeedRunner
 * @package Yui\Core\Database\Seeders
 */
class SeedRunner
{
    /**
     * Function to run seeders
     * @return void
     * @throws \Exception
     */
    public static function run(): void
    {
        $seeders = glob('app/Database/Seeders/*.php');

        if (!$seeders) {
            throw new \Exception("No seeders found");
        }

        foreach ($seeders as $seeder) {
            try {
                self::runSeeder($seeder);
                echo "Seeder {$seeder} ran successfully\n";
            } catch (\Exception $e) {
                echo "Failed to run seeder {$seeder}: {$e->getMessage()}\n";
            }
        }
    }

    /**
     * Function to run a seeder
     * @param string $seeder
     * @return void
     * @throws \Exception
     */
    private static function runSeeder(string $seeder): void
    {
        echo "Running seeder: {$seeder}\n";
        $className = 'App\\Database\\Seeders\\' . basename($seeder, '.php');

        if (!class_exists($className)) {
            throw new \Exception("Seeder class {$className} does not exist");
        }

        $seederInstance = new $className();

        if (!method_exists($seederInstance, 'run')) {
            throw new \Exception("Seeder class {$className} does not have a run method");
        }

        $seederInstance->run();
    }
}
