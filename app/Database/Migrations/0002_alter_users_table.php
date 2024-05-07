<?php

namespace App\Database\Migrations;

use Yui\Core\Database\Migration;

return new class extends Migration
{
	public string $table = 'users';

	public function alterTable(){
		return "ALTER TABLE {$this->table} ADD COLUMN email VARCHAR(255) NOT NULL";
	}
};