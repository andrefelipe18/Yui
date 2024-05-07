<?php

namespace App\Database\Migrations;

use Yui\Core\Database\Migration;

return new class extends Migration
{
	public string $table = 'users';

	public function setColumns(){
		$this->columns = [
			'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
			'name' => 'VARCHAR(255) NOT NULL',
			'age' => 'INT',
			'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
			'updated_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
		];
	}
};