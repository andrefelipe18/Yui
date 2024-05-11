<?php

namespace App\Database\Seeders;

use Yui\Core\Database\Seeders\Seeder;

class DatabaseSeeder extends Seeder
{
	public function run()
	{
		$this->seed()
		->table('users')
		->columns(
			[
				'name' => fn() => $this->faker->name(),
			]
		)
		->repeat(10)
		->exec();

		
	}
}