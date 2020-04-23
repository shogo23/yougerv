<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Users extends Migration
{
	public function up() {
		$this->forge->addfield([
			'id' => [
				'type' => 'INT',
				'constraint' => 255,
				'unassign' => TRUE,
				'auto_increment' => TRUE
			],

			'username' => [
				'type' => 'VARCHAR',
				'constraint' => 255
			],

			'password' => [
				'type' => 'VARCHAR',
				'constraint' => 255
			],
			
			'firstname' => [
				'type' => 'VARCHAR',
				'constraint' => 255
			],

			'lastname' => [
				'type' => 'VARCHAR',
				'constraint' => 255
			],

			'created' => [
				'type' => 'datetime'
			]
		]);
		$this->forge->addKey('id', TRUE);
		$this->forge->createTable('users');
	}

	//--------------------------------------------------------------------

	public function down() {
		$this->forge->dropTable('users');
	}
}
