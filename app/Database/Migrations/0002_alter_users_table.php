<?php

namespace App\Database\Migrations;

use Yui\Core\Database\Migrations\Blueprint;
use Yui\Core\Database\Migrations\Schema;

return new class
{
	public function up()
	{
		Schema::table('users', function(Blueprint $table){
			$table->raw('ADD COLUMN vaiporfavor VARCHAR(255) NOT NULL');
		});

		Schema::raw('ALTER TABLE users ADD COLUMN vaivaivai VARCHAR(255) NOT NULL');
	}

	public function down()
	{
		Schema::table('users', function(Blueprint $table){
			$table->raw('DROP COLUMN vaiporfavor');
		});

		Schema::raw('ALTER TABLE users DROP COLUMN vaivaivai');
	}
};