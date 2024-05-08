<?php

namespace App\Database\Migrations;

use Yui\Core\Database\Migrations\Blueprint;
use Yui\Core\Database\Migrations\Schema;

return new class
{
	public function up()
	{
		Schema::create('tags', function(Blueprint $table){
			$table->column('id INT AUTO_INCREMENT PRIMARY KEY');
			$table->column('name VARCHAR(255) NOT NULL');
			$table->column('user_id INT NOT NULL');
			$table->foreign('user_id', 'users', 'id');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::dropIfExists('tags');
	}
};