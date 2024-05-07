<?php

namespace App\Database\Migrations;

use Yui\Core\Database\Migration;
use Yui\Core\Database\Migrations\Blueprint;
use Yui\Core\Database\Migrations\Schema;

return new class extends Migration
{
	/**
	 * OLD METHOD, A NEW METHOD IS USED BLUEPRINT AND SCHEMA
	 */
	// public function setColumns(){
	// 	$this->columns = [
	// 		'id' => 'INT AUTO_INCREMENT PRIMARY KEY',
	// 		'name' => 'VARCHAR(255) NOT NULL',
	// 		'slug' => 'VARCHAR(255) NOT NULL',
	// 		'created_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
	// 		'updated_at' => 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
	// 	];
	// }

	// public function alterTable(){
	// 	return "ALTER TABLE {$this->table} ADD COLUMN age INT";		
	// }

	// public function raw(){
	// 	return "DROP TABLE IF EXISTS {$this->table}";
	// }

	public static function up()
	{
		Schema::create('users', function(Blueprint $table){
			$table->column('id INT AUTO_INCREMENT PRIMARY KEY');
			$table->column('name VARCHAR(255) NOT NULL');
			$table->column('slug VARCHAR(255) NOT NULL');
			$table->column('created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP');
			$table->column('updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP');
		});
	}
};