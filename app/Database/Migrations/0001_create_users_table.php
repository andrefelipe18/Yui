<?php

namespace App\Database\Migrations;

use Yui\Core\Database\Migrations\Blueprint;
use Yui\Core\Database\Migrations\Schema;

return new class
{
	public function up()
	{
		Schema::create('users', function(Blueprint $table){
			$table->column('id INT AUTO_INCREMENT PRIMARY KEY');
			$table->column('name VARCHAR(255) NOT NULL');
			$table->column('email VARCHAR(255) NOT NULL');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::dropIfExists('users');
	}
};