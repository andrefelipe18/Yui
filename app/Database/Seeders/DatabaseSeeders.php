<?php

namespace App\Database\Seeders;

use Yui\Core\Database\Seeder;

class DatabaseSeeders
{
	public static function run()
	{
		(new Seeder)->seed(
			'users',
			[
				'name' => 'fake name',
				'email' => 'fake mail'
			]
		)->repeat(5)
		->exec();
	}
}
