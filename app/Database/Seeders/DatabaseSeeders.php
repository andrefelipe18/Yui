<?php

namespace App\Database\Seeders;

use Yui\Core\Database\Seeder;

class DatabaseSeeders
{
	public Seeder $seeder = new Seeder();

	public function run()
	{
		$this->seeder
		->table('users')
		->columns(
			[
				'name' => 'Fake Name',
			]
		)
		->repeat(1)
		->exec();
	}
}
