<?php

namespace App\Database\Migrations;

use Yui\Core\Database\Migration;

return new class extends Migration
{
	public string $table = 'tests';

	// public function setColumns(){
	// 	$this->columns = [
	// 		'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
	// 		'name' => 'VARCHAR(255) NOT NULL',
	// 		'slug' => 'VARCHAR(255) NOT NULL',
	// 		'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
	// 		'updated_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
	// 	];
	// }

	public function alterTable(){
		return "ALTER TABLE {$this->table} ADD COLUMN age INT";		
	}

	// public function dropColumn(){
	// 	$sql = "ALTER TABLE {$this->table} DROP COLUMN age";
	// 	return $sql;
	// }

	// public function renameColumn(){
	// 	$sql = "ALTER TABLE {$this->table} CHANGE COLUMN age age2 INT";
	// 	return $sql;
	// }

	// public function renameTable(){
	// 	$sql = "RENAME TABLE {$this->table} TO tests2";
	// 	return $sql;
	// }
};