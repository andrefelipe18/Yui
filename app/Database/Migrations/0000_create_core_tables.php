<?php

namespace App\Database\Migrations;

use Yui\Core\Database\Migrations\Blueprint;
use Yui\Core\Database\Migrations\Schema;

/**
 * This class is responsible for creating the tables used by the framework
 */
return new class
{
	public function up()
	{
		Schema::create('migrations_history', function(Blueprint $table){
			$table->column('id INT AUTO_INCREMENT PRIMARY KEY');
			$table->column('name VARCHAR(255) NOT NULL');
			$table->timestamps();
		});
	}
};