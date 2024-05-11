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
				'name' => $this->faker->name(),
			]
		)
		->repeat(1)
		->exec();

		
	}
}