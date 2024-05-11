<?php

namespace Yui\Core\Database\Seeders;

class SeedRunner
{
	public static function run()
	{
		$seeders = glob('app/Database/Seeders*.php');

		if(!$seeders) {
			throw new \Exception("No seeders found");
		}

        foreach ($seeders as $seeder) {
            echo "Running seeder {$seeder}..." . PHP_EOL;

            $className = 'App\\Database\\Seeders' . basename($seeder, '.php');

            // Instantiate the seeder class
            $seederInstance = new $className();
            $seederInstance->run();

            echo "OK" . PHP_EOL;
        }
	}
}